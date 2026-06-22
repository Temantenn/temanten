#!/usr/bin/env python3
"""
QRIS master string sanity check.

Run BEFORE you trust the payment page:
    python3 scripts/check_qris_master.py                 # checks .env in cwd
    python3 scripts/check_qris_master.py /path/to/.env   # explicit path
    python3 scripts/check_qris_master.py --string "00020101021226..."  # inline

Exits 0 if the master string looks like a real EMVCo QRIS, 1 if it's a
placeholder / invalid. Prints actionable hint on failure.

This exists because the placeholder trap silently breaks the payment page:
unit test passes, deploy succeeds, user scans live QR, e-wallet shows nothing.
The literal string "DEMO-QRIS-MASTER-STRING-FOR-TESTING-PURPOSES-ONLY" was
in temanten .env for weeks and 14+ test users hit it before anyone noticed.

Detects:
  - Missing env var
  - Length < 100 (real QRIS is 200-400 chars)
  - Doesn't start with 000201 (Payload Format Indicator)
  - Contains TLV parse errors
  - Missing required tags (00, 01, 26, 52, 53, 58, 59, 60, 63)
  - CRC mismatch
  - Common placeholder patterns (DEMO-, TEST-, PLACEHOLDER-, XXX)

Prints the decoded merchant name + city + GUI as a sanity read.
"""
import sys, os, re, argparse

PLACEHOLDER_PATTERNS = [
    r"^DEMO[-_]",
    r"^TEST[-_]",
    r"^PLACEHOLDER",
    r"^XXX",
    r"^TODO",
    r"^REPLACE",
    r"^YOUR[-_]",
    r"CHANGEME",
    r"FOR[-_]TESTING[-_]PURPOSES[-_]ONLY",
]

REQUIRED_TAGS = {"00", "01", "26", "52", "53", "58", "59", "60", "63"}

def parse_tlv(s: str):
    """Return (tlvs_dict, error_msg)."""
    out = {}
    pos = 0
    while pos < len(s):
        if pos + 4 > len(s):
            return None, f"truncated TLV at pos {pos}"
        tag = s[pos:pos+2]
        try:
            tag_len = int(s[pos+2:pos+4])
        except ValueError:
            return None, f"non-numeric length at pos {pos+2}: {s[pos+2:pos+4]!r}"
        if pos + 4 + tag_len > len(s):
            return None, f"tag {tag} length {tag_len} exceeds payload (pos {pos}, total {len(s)})"
        out[tag] = s[pos+4:pos+4+tag_len]
        pos += 4 + tag_len
    return out, None

def crc16_xmodem(data: str) -> int:
    crc = 0xFFFF
    for ch in data:
        crc ^= ord(ch) << 8
        for _ in range(8):
            crc = ((crc << 1) ^ 0x1021) & 0xFFFF if (crc & 0x8000) else (crc << 1) & 0xFFFF
    return crc

def read_env(path: str) -> dict:
    if not os.path.isfile(path):
        return {}
    env = {}
    with open(path) as f:
        for line in f:
            line = line.strip()
            if not line or line.startswith("#") or "=" not in line:
                continue
            k, v = line.split("=", 1)
            env[k.strip()] = v.strip().strip('"').strip("'")
    return env

def check(s: str) -> tuple[bool, list[str]]:
    """Return (ok, list_of_issues). ok=True means looks like real QRIS."""
    issues = []
    if not s:
        return False, ["EMPTY — QRIS_MASTER_STRING not set in .env"]

    for pat in PLACEHOLDER_PATTERNS:
        if re.search(pat, s, re.IGNORECASE):
            issues.append(f"PLACEHOLDER detected (matches /{pat}/) — test/demo string, NOT a real QRIS")

    if len(s) < 100:
        issues.append(f"TOO SHORT ({len(s)} chars, real QRIS is 200-400)")

    if not s.startswith("000201"):
        issues.append(f"WRONG PREFIX (expected '000201' Payload Format Indicator, got {s[:8]!r})")

    tlvs, err = parse_tlv(s)
    if err:
        issues.append(f"PARSE ERROR: {err}")
        return False, issues

    missing = REQUIRED_TAGS - set(tlvs.keys())
    if missing:
        issues.append(f"MISSING TAGS: {sorted(missing)}")

    if "63" in tlvs:
        computed = f"{crc16_xmodem(s[:-4]):04X}"
        if tlvs["63"].upper() != computed:
            issues.append(f"BAD CRC (got {tlvs['63']}, expected {computed})")

    return len(issues) == 0, issues

def decode_summary(s: str) -> str:
    tlvs, err = parse_tlv(s)
    if err or not tlvs:
        return "  (unparseable)"
    lines = []
    gui = ""
    if "26" in tlvs and len(tlvs["26"]) >= 4:
        if tlvs["26"][:2] == "00":
            gui_len = int(tlvs["26"][2:4])
            gui = tlvs["26"][4:4+gui_len]
    lines.append(f"  Merchant name : {tlvs.get('59', '?')}")
    lines.append(f"  Merchant city : {tlvs.get('60', '?')}")
    lines.append(f"  Currency      : {'IDR' if tlvs.get('53') == '360' else tlvs.get('53', '?')}")
    lines.append(f"  GUI (acquirer): {gui or '?'}")
    lines.append(f"  Init method   : {'12 dynamic (one-shot)' if tlvs.get('01') == '12' else '11 static (reusable)'}")
    if "54" in tlvs:
        lines.append(f"  Amount (raw)  : {tlvs['54']}  <-- encoded in master, will be OVERRIDDEN by service")
    return "\n".join(lines)

def main():
    p = argparse.ArgumentParser(description="Check QRIS master string for placeholder/invalid")
    p.add_argument("env_path", nargs="?", default=".env", help="Path to .env (default: cwd .env)")
    p.add_argument("--string", "-s", help="Check an inline string instead of .env")
    p.add_argument("--quiet", "-q", action="store_true", help="Only print on FAIL")
    args = p.parse_args()

    s = None
    source = ""
    if args.string:
        s = args.string
        source = "inline --string"
    else:
        env = read_env(args.env_path)
        s = env.get("QRIS_MASTER_STRING", "")
        source = f"env QRIS_MASTER_STRING in {args.env_path}"

    if not s and not args.quiet:
        print(f"[FAIL] No QRIS_MASTER_STRING found in {source}")
        print()
        print("Fix: get the real string from your acquirer dashboard (DANA/OVO/BCA/Midtrans QRIS merchant portal)")
        print('     and add to .env: QRIS_MASTER_STRING=00020101021226...')
        sys.exit(1)

    ok, issues = check(s)
    if args.quiet and ok:
        return

    print(f"Source: {source}")
    print(f"Length: {len(s)} chars")
    print()
    if ok:
        print("[OK] Master string looks like a real EMVCo QRIS")
        print()
        print("Decoded content (what the e-wallet will see):")
        print(decode_summary(s))
        sys.exit(0)
    else:
        print(f"[FAIL] Master string has {len(issues)} problem(s):")
        for i, iss in enumerate(issues, 1):
            print(f"  {i}. {iss}")
        print()
        print("Fix options:")
        print("  1. Get real string from acquirer dashboard (DANA/OVO/BCA/Midtrans QRIS merchant portal)")
        print("  2. Copy a working QRIS from a friend who has a merchant account (for dev/staging)")
        print("  3. Generate a test fixture via scripts/verify_qris.php (code verification only, not real payment)")
        print()
        print(f"Current value: {s[:60]}{'...' if len(s) > 60 else ''}")
        sys.exit(1)

if __name__ == "__main__":
    main()

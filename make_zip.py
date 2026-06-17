import os
import sys
import zipfile

ROOT = os.path.abspath(os.path.dirname(__file__))
OUTPUT = os.path.join(ROOT, "temanten-deploy.zip")

EXCLUDE_DIRS = {
    "node_modules",
    ".git",
    ".github",
    "storage\\framework\\cache",
    "storage\\framework\\sessions",
    "storage\\framework\\views",
    "storage\\logs",
    "bootstrap\\cache",
    "test-results",
    ".idea",
    ".vscode",
}

EXCLUDE_FILE_EXTS = {".log", ".tmp"}

def should_skip(rel: str) -> bool:
    parts = rel.split("\\")
    for p in parts:
        if p in EXCLUDE_DIRS:
            return True
    head = "\\".join(parts[:-1])
    for ed in EXCLUDE_DIRS:
        if head == ed or head.startswith(ed + "\\"):
            return True
    name = parts[-1]
    _, ext = os.path.splitext(name)
    if ext.lower() in EXCLUDE_FILE_EXTS:
        return True
    return False

count = 0
with zipfile.ZipFile(OUTPUT, "w", compression=zipfile.ZIP_DEFLATED, compresslevel=9) as zf:
    for dirpath, dirnames, filenames in os.walk(ROOT):
        dirnames[:] = [d for d in dirnames if d not in EXCLUDE_DIRS]
        for fn in filenames:
            full = os.path.join(dirpath, fn)
            rel = os.path.relpath(full, ROOT)
            if rel == "make_zip.py" or rel == "temanten-deploy.zip":
                continue
            if should_skip(rel):
                continue
            zf.write(full, rel)
            count += 1

size = os.path.getsize(OUTPUT)
print(f"OK files={count} zip={OUTPUT} bytes={size} mb={size/1024/1024:.2f}")

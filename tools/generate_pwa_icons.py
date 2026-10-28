#!/usr/bin/env python3
"""Generate PWA PNG icons from the project's SVG. Requires cairosvg: pip install cairosvg."""
from pathlib import Path
import cairosvg

public = Path(__file__).resolve().parents[1] / "public"
source = str(public / "pwa-icon.svg")
for size, name in [(192, "pwa-192.png"), (512, "pwa-512.png"), (180, "apple-touch-icon.png")]:
    cairosvg.svg2png(url=source, write_to=str(public / name), output_width=size, output_height=size)
    print(f"Created {name}")

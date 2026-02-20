# Lunar Commitment

A personal tradition of making the first commit of each Lunar New Year — a symbolic gesture wishing for a smooth, successful, and prosperous year ahead.

## About

Every year around the Lunar New Year (Tet), this project receives its first commit of the year. Each commit includes a themed template celebrating the corresponding zodiac year.

| Year | Zodiac | Vietnamese | Template |
|------|--------|------------|----------|
| 2025 | Snake  | At Ty      | `2025`   |
| 2026 | Horse  | Binh Ngo   | `2026`   |

## How It Works

The app automatically loads the template matching the current year. If no template exists for the current year, it falls back to the nearest available year — useful when the Gregorian calendar has already moved to a new year but Lunar New Year hasn't arrived yet.

```
GET /                    → auto-detect year template
GET /?t=2025             → load specific year template
GET /?t=default          → load default template
```

## Running Locally

```bash
php -S localhost:8000
```

Then open [http://localhost:8000](http://localhost:8000) in your browser.

## Project Structure

```
lunar-commitment/
├── index.php              # Entry point
├── HelloWorld.php         # Template resolver
└── templates/
    ├── default.html       # Default fallback template
    ├── 2025.html          # Year of the Snake
    └── 2026.html          # Year of the Horse
```

## License

MIT License - see [LICENSE](LICENSE) for details.

# Legacy crawler

Crawler инвентаризирует старый публичный сайт училища и формирует воспроизводимый реестр миграции.

## Запуск

```bash
python -m venv .venv
# Windows: .venv\\Scripts\\activate
# Linux/macOS: source .venv/bin/activate
pip install -r tools/legacy_crawler/requirements.txt
python tools/legacy_crawler/crawl.py
```

Результаты создаются в `storage/legacy-audit/`:

- `legacy-site-inventory.json`
- `legacy-site-inventory.csv`
- `legacy-site-report.md`

Crawler сохраняет URL родителя, глубину обхода, legacy `id/page`, HTTP status, классификацию, число изображений/документов и ссылки. Файлы старого сайта пока только инвентаризируются — скачивание будет отдельным этапом импорта, чтобы аудит был безопасным и повторяемым.

Можно ограничить тестовый проход: `python tools/legacy_crawler/crawl.py --max-pages 100 --delay 0.3`.

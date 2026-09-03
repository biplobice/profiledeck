# Contributing to ProfileDeck

Thank you for helping improve ProfileDeck.

## Development setup

Follow the SQLite quick start in `README.md`, then create a focused branch for
your change.

Before opening a pull request, run:

```bash
vendor/bin/pint --test
php artisan test
npm run build
```

## Pull requests

- Keep changes focused and explain the user-facing reason for them.
- Add or update tests for behavior changes.
- Do not commit `.env`, production data, personal seeders, exported résumés,
  profile photos, database dumps, or credentials.
- Use fictional information in fixtures, screenshots, and documentation.
- Preserve compatibility with SQLite and MySQL unless a change explicitly
  documents otherwise.

## Reporting problems

Open an issue with reproduction steps, expected behavior, actual behavior, and
relevant Laravel/PHP versions. Do not include secrets or private profile data.

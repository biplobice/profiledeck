# Security policy

Please report security vulnerabilities privately to the repository maintainer
instead of opening a public issue.

ProfileDeck is a self-hosted application. Operators are responsible for:

- replacing the demo administrator credentials before deployment;
- disabling debug mode in production;
- protecting `.env`, database backups, uploaded media, and generated CVs;
- configuring HTTPS, sessions, queues, cache, mail, and database credentials;
- applying Laravel, Filament, and other dependency security updates.

The demo data is fictional and is not intended for a production deployment.

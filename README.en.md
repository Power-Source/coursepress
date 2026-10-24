# CoursePress

[Deutsch](README.md) | **English**

[![Version](https://img.shields.io/badge/Version-1.0.2-2271b1?style=flat-square)](readme.txt)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb4?style=flat-square&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-up%20to%207.1.0-21759b?style=flat-square&logo=wordpress&logoColor=white)
![ClassicPress](https://img.shields.io/badge/ClassicPress-2.7.4-03768e?style=flat-square)
[![License](https://img.shields.io/badge/License-GPL--2.0--or--later-2ea44f?style=flat-square)](https://www.gnu.org/licenses/gpl-2.0.html)

**CoursePress** is a learning-management system for ClassicPress. Create, publish, and manage online courses with lessons, interactive modules, enrolments, assessments, certificates, and notifications.

![CoursePress logo](themes/coursepress/images/logo-default.png)

## Features

- **Course management:** Create courses, units, and learning modules through a guided setup process.
- **Interactive learning content:** Combine text, video, audio, downloads, quizzes, coding assignments, tasks, and discussions.
- **Participant management:** Manage enrolments, progress, assessments, and reports centrally.
- **Instructors:** Assign multiple instructors to a course and invite them by email.
- **Assessments and certificates:** Provide automated assessments, individual feedback, and printable completion certificates.
- **Selling courses:** Use paywalls and integrations with MarketPress and WooCommerce.
- **Notifications:** Configure email templates and reminders for learners and instructors.
- **Theme, widgets, and shortcodes:** Use the included CoursePress theme and building blocks in existing themes.
- **German as the default language:** German source strings with an English translation catalog for the `cp` text domain.

## Requirements

| Component | Requirement |
| --- | --- |
| CMS | ClassicPress 4.9 or later |
| PHP | 7.0 or later |
| Database | A database supported by ClassicPress |

Paid courses additionally require a suitable e-commerce integration, such as MarketPress or WooCommerce.

## Installation

1. Download the repository as a ZIP archive or clone it:

   ```bash
   git clone https://github.com/Power-Source/coursepress.git
   ```

2. Place the `coursepress` folder in the `wp-content/plugins/` directory of your ClassicPress installation.
3. Open **Plugins** in the administration area and activate **CoursePress**.
4. Open the new **CoursePress** menu item to create your first course.

### Multisite networks

In ClassicPress multisite installations, CoursePress can be activated per site or through network administration.

## Quick start

1. Open **CoursePress → New Course**.
2. Enter the title, short description, language, and course description.
3. Assign one or more instructors.
4. Create units and add learning modules such as lessons, quizzes, coding assignments, or tasks.
5. Configure enrolment, course pricing, and any required payment integration.
6. Review the course preview and publish the course.

Detailed instructions with screenshots and configuration guidance are available in the [documentation](https://cp-psource.github.io/coursepress/).

## Translations

CoursePress uses the `cp` text domain.

- German strings are the plugin's source strings.
- The English catalog is available in [`languages/cp-en_US.po`](languages/cp-en_US.po).
- The compiled English translation is available in [`languages/cp-en_US.mo`](languages/cp-en_US.mo).
- [`languages/cp.pot`](languages/cp.pot) is the template for additional languages.

When adding or changing user-facing text, preserve placeholders, HTML, and plural forms in every translation catalog.

## Development

Install development dependencies with Composer:

```bash
composer install
```

Before contributing, at minimum lint the changed PHP files:

```bash
php -l path/to/changed-file.php
```

Please keep changes focused, use the existing `cp` text domain, and update directly affected documentation or translations.

## Security

Please do not disclose security vulnerabilities publicly in an issue. Instead, use the [private security advisories](https://github.com/Power-Source/coursepress/security/advisories/new) for this repository.

## License

CoursePress is released under the [GNU General Public License, version 2](license.txt).

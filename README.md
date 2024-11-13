![SharpAPI GitHub cover](https://sharpapi.com/sharpapi-github-laravel-bg.jpg "SharpAPI Laravel Client")

# Resume Parser/CV Parser for Laravel with AI-powered SharpAPI

## 🚀 Leverage AI API to streamline resume parsing and data extraction in your HR Tech applications.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sharpapi/laravel-resume-parser.svg?style=flat-square)](https://packagist.org/packages/sharpapi/laravel-resume-parser)
[![Total Downloads](https://img.shields.io/packagist/dt/sharpapi/laravel-resume-parser.svg?style=flat-square)](https://packagist.org/packages/sharpapi/laravel-resume-parser)

Check the details at SharpAPI's [Resume Parsing API](https://sharpapi.com/en/catalog/ai/hr-tech/resume-cv-parsing) page.

---

## Requirements

- PHP >= 8.1
- Laravel >= 9.0

---

## Installation

Follow these steps to install and set up the SharpAPI Laravel Resume Parser package.

1. Install the package via `composer`:

```bash
composer require sharpapi/laravel-resume-parser
```

2. Register at [SharpAPI.com](https://sharpapi.com/) to obtain your API key.

3. Set the API key in your `.env` file:

```bash
SHARP_API_KEY=your_api_key_here
```

4. **[OPTIONAL]** Publish the configuration file:

```bash
php artisan vendor:publish --tag=sharpapi-resume-parser
```

---
## Key Features

- **Automated Resume Parsing with AI**: Efficiently parse and extract structured information from resumes in various formats, including PDF, DOC, DOCX, TXT, and RTF.
- **Multi-language Support**: Supports 80+ languages for parsing results.
- **Consistent Data Format**: Ensures predictable JSON structure for parsed data.
- **Robust Polling for Results**: Polling-based API response handling with customizable intervals.
- **API Availability and Quota Check**: Check API availability and current usage quotas with `ping` and `quota` endpoints.

---

## Usage

You can inject the `ResumeParserService` class to access parsing functionalities. For best results, especially with batch processing, use Laravel’s queuing system to optimize job dispatch and result polling.

### Basic Workflow

1. **Dispatch Job**: Send a resume file to the API using `parseResume`, which returns a status URL.
2. **Poll for Results**: Use `fetchResults($statusUrl)` to poll until the job completes or fails.
3. **Process Result**: After completion, retrieve the results from the `SharpApiJob` object returned.

> **Note**: Each job typically takes a few seconds to complete. Once completed successfully, the status will update to `success`, and you can process the results as JSON, array, or object format.

---

### Controller Example

Here is an example of how to use `ResumeParserService` within a Laravel controller:

```php
<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use SharpAPI\ResumeParser\ResumeParserService;

class ResumeController extends Controller
{
    protected ResumeParserService $resumeParserService;

    public function __construct(ResumeParserService $resumeParserService)
    {
        $this->resumeParserService = $resumeParserService;
    }

    /**
     * @throws GuzzleException
     */
    public function parseResume()
    {
        $statusUrl = $this->resumeParserService->parseResume(
            '/path/to/resume.pdf', 
            'English'   // OPTIONAL output language, English is the default anyway 
        );
        $result = $this->resumeParserService->fetchResults($statusUrl);

        return response()->json($result->getResultJson());
    }
}
```

### Handling Guzzle Exceptions

All requests are managed by Guzzle, so it's helpful to be familiar with [Guzzle Exceptions](https://docs.guzzlephp.org/en/stable/quickstart.html#exceptions).

Example:

```php
use GuzzleHttp\Exception\ClientException;

try {
    $statusUrl = $this->resumeParserService->parseResume('/path/to/resume.pdf', 'English');
} catch (ClientException $e) {
    echo $e->getMessage();
}
```

---

## Optonal Configuration

You can customize the configuration by setting the following environment variables in your `.env` file:

```bash
SHARP_API_KEY=your_api_key_here
SHARP_API_JOB_STATUS_POLLING_WAIT=180
SHARP_API_JOB_STATUS_USE_POLLING_INTERVAL=true
SHARP_API_JOB_STATUS_POLLING_INTERVAL=10
SHARP_API_BASE_URL=https://sharpapi.com/api/v1
```

---

### Available Endpoints

#### Resume Parsing

Parses a resume in multiple formats and returns structured data points.

```php
$statusUrl = $resumeParserService->parseResume('/path/to/resume.pdf', 'English');
```

#### Quota Check

Returns information about the subscription, including usage and remaining quota.

```php
$quotaInfo = $resumeParserService->quota();
```

#### API Lightweight Availability Check (Ping)

Checks the API availability and server timestamp.

```php
$pingResponse = $resumeParserService->ping();
```

---

## AI Resume Parsing Data Format Example

```json
{
  "data": {
    "type": "api_job_result",
    "id": "5a113c4d-38e9-43e5-80f4-ec3fdea3420e",
    "attributes": {
      "status": "success",
      "type": "hr_parse_resume",
      "result": {
        "positions": [
          {
            "skills": [
              "Acceptance testing",
              "Technical investigation",
              "Exploratory testing",
              "Agile",
              "Test environments",
              "Test management tools",
              "UAT knowledge",
              "Writing test reports",
              "Organising, conducting and supporting test activities",
              "Performance testing",
              "Integration testing",
              "Rapid response to equipment failures",
              "Implementing immediate repairs",
              "Participating in audits and reviews",
              "Monitoring and reporting repair trends",
              "Drawings and documentation updates",
              "Executing test cases",
              "Documenting results and defects",
              "Testing and fault finding finished systems",
              "Reporting issues to Test Manager",
              "Assisting in software installation",
              "Experience of testing Web, PC and mobile based software",
              "Understanding iterative software development lifecycle",
              "Manual testing methods and processes",
              "Technical knowledge of Test Systems hardware and software",
              "Planning and task management skills",
              "Microsoft operating systems",
              "Testing GUI based software"
            ],
            "country": "United Kingdom",
            "end_date": null,
            "start_date": "2008-06-01",
            "job_details": "Responsible for the whole test process from planning, through test plan development, execution & result reporting. Also involved in the development and improvement of the test functions, putting forward suggestions and implementing plans accordingly. Duties included organising, conducting and supporting test activities, performance testing, integration testing, rapid response to equipment failures, implementing immediate repairs, participating in audits and reviews, monitoring and reporting repair trends, updating drawings and documentation, executing test cases, documenting results and defects, testing and fault finding finished systems, reporting issues to Test Manager, and assisting in software installation.",
            "company_name": "IT & Telecoms Company",
            "position_name": "Test Engineer"
          }
        ],
        "candidate_name": "Linda Harris",
        "candidate_email": "linda.h@dayjob.co.uk",
        "candidate_phone": "02476 000 0000, 0887 222 9999",
        "candidate_address": "34 Made Up Road, Coventry, CV66 7RF",
        "candidate_language": "English",
        "education_qualifications": [
          {
            "country": "United Kingdom",
            "end_date": "2008-06-01",
            "start_date": "2005-09-01",
            "degree_type": "Bachelor’s Degree or equivalent",
            "school_name": "Nuneaton University",
            "school_type": "University or equivalent",
            "learning_mode": "In-person learning",
            "education_details": "",
            "faculty_department": "",
            "specialization_subjects": "Software Engineering"
          },
          {
            "country": "United Kingdom",
            "end_date": "2005-06-01",
            "start_date": "2000-09-01",
            "degree_type": "High School/Secondary School Diploma or equivalent",
            "school_name": "Coventry North School",
            "school_type": "High School/Secondary School or equivalent",
            "learning_mode": "In-person learning",
            "education_details": "A levels: Maths (A), English (B), Technology (B), Science (C)",
            "faculty_department": "",
            "specialization_subjects": ""
          }
        ],
        "candidate_spoken_languages": [
          "German"
        ],
        "candidate_honors_and_awards": [],
        "candidate_courses_and_certifications": [
          "ISEB certification"
        ]
      }
    }
  }
}
```

---

## Support & Feedback

For issues or suggestions, please:

- [Open an issue on GitHub](https://github.com/sharpapi/laravel-resume-parser/issues)
- Join our [Telegram community](https://t.me/sharpapi_community)

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for a detailed list of changes.

---

## Credits

- [A2Z WEB LTD](https://github.com/a2zwebltd)
- [Dawid Makowski](https://github.com/makowskid)
- Enhance your [Laravel AI](https://sharpapi.com/) capabilities!

---

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

## Follow Us

Stay updated with news, tutorials, and case studies:

- [SharpAPI on X (Twitter)](https://x.com/SharpAPI)
- [SharpAPI on YouTube](https://www.youtube.com/@SharpAPI)
- [SharpAPI on Vimeo](https://vimeo.com/SharpAPI)
- [SharpAPI on LinkedIn](https://www.linkedin.com/products/a2z-web-ltd-sharpapicom-automate-with-aipowered-api/)
- [SharpAPI on Facebook](https://www.facebook.com/profile.php?id=61554115896974)
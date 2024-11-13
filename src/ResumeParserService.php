<?php

declare(strict_types=1);

namespace SharpAPI\ResumeParser;

use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use SharpAPI\Core\Client\SharpApiClient;

/**
 * @api
 */
class ResumeParserService extends SharpApiClient
{
    /**
     * Initializes a new instance of the class.
     *
     * @throws InvalidArgumentException if the API key is empty.
     */
    public function __construct()
    {
        parent::__construct(config('sharpapi-client.api_key'));
        $this->setApiBaseUrl(
            config(
                'sharpapi-client.base_url',
                'https://sharpapi.com/api/v1'
            )
        );
        $this->setApiJobStatusPollingInterval(
            (int) config(
                'sharpapi-client.api_job_status_polling_interval',
                5)
        );
        $this->setApiJobStatusPollingWait(
            (int) config(
                'sharpapi-client.api_job_status_polling_wait',
                180)
        );
        $this->setUserAgent('SharpAPILaravelAgent/1.2.2');

    }

    /**
     * Parses a resume (CV) file from multiple formats (PDF/DOC/DOCX/TXT/RTF)
     * and returns an extensive JSON object of data points.
     *
     * An optional language parameter can also be provided (`English` value is set as the default one) .
     *
     * @param  string  $filePath  The path to the resume file.
     * @param  string|null  $language  The language of the resume file. Defaults to 'English'.
     * @return string The parsed data or an error message.
     *
     * @throws GuzzleException
     *
     * @api
     */
    public function parseResume(
        string $filePath,
        ?string $language = null
    ): string {
        $response = $this->makeRequest(
            'POST',
            '/hr/parse_resume',
            ['language' => $language],
            $filePath
        );

        return $this->parseStatusUrl($response);
    }
}

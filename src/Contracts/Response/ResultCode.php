<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Response;

use MyCLabs\Enum\Enum;

/**
 * @see https://library.vuforia.com/content/vuforia-library/en/articles/Solution/How-To-Use-the-Vuforia-Web-Services-API.html#How-To-Interperete-VWS-API-Result-Codes
 *
 * @method static self SUCCESS()
 * @method static self TARGET_CREATED()
 * @method static self AUTHENTICATION_FAILURE()
 * @method static self REQUEST_TIME_TOO_SKEWED()
 * @method static self TARGET_NAME_EXIST()
 * @method static self REQUEST_QUOTA_REACHED()
 * @method static self TARGET_STATUS_PROCESSING()
 * @method static self TARGET_STATUS_NOT_SUCCESS()
 * @method static self TARGET_QUOTA_REACHED()
 * @method static self PROJECT_SUSPENDED()
 * @method static self PROJECT_INACTIVE()
 * @method static self PROJECT_HAS_NO_API_ACCESS()
 * @method static self UNKNOWN_TARGET()
 * @method static self BAD_IMAGE()
 * @method static self IMAGE_TOO_LARGE()
 * @method static self METADATA_TOO_LARGE()
 * @method static self DATE_RANGE_ERROR()
 * @method static self FAIL()
 */
class ResultCode extends Enum
{
    /**
     * HTTP OK (2OO): Transaction succeeded
     */
    private const SUCCESS = 'Success';

    /**
     * HTTP Created (2O1): Target created (target POST response)
     */
    private const TARGET_CREATED = 'TargetCreated';

    /**
     * HTTP Authentication failure (401): Signature authentication failed
     */
    private const AUTHENTICATION_FAILURE = 'AuthenticationFailure';

    /**
     * HTTP Forbidden (403): Request timestamp outside allowed range
     */
    private const REQUEST_TIME_TOO_SKEWED = 'RequestTimeTooSkewed';

    /**
     * HTTP Forbidden (403): The corresponding target name already exists (target POST/PUT response)
     */
    private const TARGET_NAME_EXIST = 'TargetNameExist';

    /**
     * HTTP Forbidden (403): The maximum number of API calls for this database has been reached.
     */
    private const REQUEST_QUOTA_REACHED = 'RequestQuotaReached';

    /**
     * HTTP Forbidden (403): The target is in the processing state and cannot be updated.
     */
    private const TARGET_STATUS_PROCESSING = 'TargetStatusProcessing';

    /**
     * HTTP Forbidden (403): The request could not be completed because the target is not in the success state.
     */
    private const TARGET_STATUS_NOT_SUCCESS = 'TargetStatusNotSuccess';

    /**
     * HTTP Forbidden (403): The maximum number of targets for this database has been reached.
     */
    private const TARGET_QUOTA_REACHED = 'TargetQuotaReached';

    /**
     * HTTP Forbidden (403): The request could not be completed because this database has been suspended.
     */
    private const PROJECT_SUSPENDED = 'ProjectSuspended';

    /**
     * HTTP Forbidden (403): The request could not be completed because this database is inactive.
     */
    private const PROJECT_INACTIVE = 'ProjectInactive';

    /**
     * HTTP Forbidden (403): The request could not be completed because this database is not allowed to make API requests.
     */
    private const PROJECT_HAS_NO_API_ACCESS = 'ProjectHasNoApiAccess';

    /**
     * HTTP Not Found (404): The specified target ID does not exist (target PUT/GET/DELETE response)
     */
    private const UNKNOWN_TARGET = 'UnknownTarget';

    /**
     * HTTP Unprocessable Entity (422): Image corrupted or format not supported (target POST/PUT response)
     */
    private const BAD_IMAGE = 'BadImage';

    /**
     * HTTP Unprocessable Entity (422): Target metadata size exceeds maximum limit (target POST/PUT response)
     */
    private const IMAGE_TOO_LARGE = 'ImageTooLarge';

    /**
     * HTTP Unprocessable Entity (422): Image size exceeds maximum limit (target POST/PUT response)
     */
    private const METADATA_TOO_LARGE = 'MetadataTooLarge';

    /**
     * HTTP Unprocessable Entity (422): Start date is after the end date
     */
    private const DATE_RANGE_ERROR = 'DateRangeError';

    /**
     * HTTP Unprocessable Entity (422): The request was invalid and could not be processed. Check the request headers and fields.
     * Internal Server Error (500): The server encountered an internal error; please retry the request
     */
    private const FAIL = 'Fail';
}

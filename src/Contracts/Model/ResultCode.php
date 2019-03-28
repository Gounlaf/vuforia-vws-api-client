<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Model;

interface ResultCode
{
    /**
     * HTTP OK (2OO): Transaction succeeded
     */
    const SUCCESS = 'Success';

    /**
     * HTTP Created (2O1): Target created (target POST response)
     */
    const TARGET_CREATED = 'TargetCreated';

    /**
     * HTTP Authentication failure (401): Signature authentication failed
     */
    const AUTHENTICATION_FAILURE = 'AuthenticationFailure';

    /**
     * HTTP Forbidden (403): Request timestamp outside allowed range
     */
    const REQUEST_TIME_TOO_SKEWED = 'RequestTimeTooSkewed';

    /**
     * HTTP Forbidden (403): The corresponding target name already exists (target POST/PUT response)
     */
    const TARGET_NAME_EXIST = 'TargetNameExist';

    /**
     * HTTP Forbidden (403): The maximum number of API calls for this database has been reached.
     */
    const REQUEST_QUOTA_REACHED = 'RequestQuotaReached';

    /**
     * HTTP Forbidden (403): The target is in the processing state and cannot be updated.
     */
    const TARGET_STATUS_PROCESSING = 'TargetStatusProcessing';

    /**
     * HTTP Forbidden (403): The request could not be completed because the target is not in the success state.
     */
    const TARGET_STATUS_NOT_SUCCESS = 'TargetStatusNotSuccess';

    /**
     * HTTP Forbidden (403): The maximum number of targets for this database has been reached.
     */
    const TARGET_QUOTA_REACHED = 'TargetQuotaReached';

    /**
     * HTTP Forbidden (403): The request could not be completed because this database has been suspended.
     */
    const PROJECT_SUSPENDED = 'ProjectSuspended';

    /**
     * HTTP Forbidden (403): The request could not be completed because this database is inactive.
     */
    const PROJECT_INACTIVE = 'ProjectInactive';

    /**
     * HTTP Forbidden (403): The request could not be completed because this database is not allowed to make API requests.
     */
    const PROJECT_HAS_NO_API_ACCESS = 'ProjectHasNoApiAccess';

    /**
     * HTTP Not Found (404): The specified target ID does not exist (target PUT/GET/DELETE response)
     */
    const UNKNOWN_TARGET = 'UnknownTarget';

    /**
     * HTTP Unprocessable Entity (422): Image corrupted or format not supported (target POST/PUT response)
     */
    const BAD_IMAGE = 'BadImage';

    /**
     * HTTP Unprocessable Entity (422): Target metadata size exceeds maximum limit (target POST/PUT response)
     */
    const IMAGE_TOO_LARGE = 'ImageTooLarge';

    /**
     * HTTP Unprocessable Entity (422): Image size exceeds maximum limit (target POST/PUT response)
     */
    const METADATA_TOO_LARGE = 'MetadataTooLarge';

    /**
     * HTTP Unprocessable Entity (422): Start date is after the end date
     */
    const DATE_RANGE_ERROR = 'DateRangeError';

    /**
     * HTTP Unprocessable Entity (422): The request was invalid and could not be processed. Check the request headers and fields.
     * Internal Server Error (500): The server encountered an internal error; please retry the request
     */
    const FAIL = 'Fail';
}

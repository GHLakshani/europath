<?php

namespace App\Enums;

enum CandidateStatus: string
{
    case REGISTERED          = 'registered';
    case DOCUMENT_PENDING    = 'document_pending';
    case DOCUMENT_COMPLETED  = 'document_completed';

    case VISA_APPLIED        = 'visa_applied';
    case VISA_APPROVED       = 'visa_approved';
    case VISA_REJECTED       = 'visa_rejected';

    case WORK_PERMIT_PENDING = 'work_permit_pending';
    case WORK_PERMIT_APPROVED= 'work_permit_approved';
    case WORK_PERMIT_REJECTED= 'work_permit_rejected';

    case DEPARTURE_PENDING   = 'departure_pending';
    case DEPARTED            = 'departed';

    case CANCELLED           = 'cancelled';
}

<?php

class Unister_View_Helper_ApplicationStatus
{
    /**
     * Get apllication status as string
     *
     */
    public function applicationStatus($status)
    {
        switch ((int) $status) {
            case APPLICATION_STATUS_TYPE_EINGEGANGEN:
                return 'eingegangen';
            case APPLICATION_STATUS_TYPE_IN_BEARBEITUNG:
                return 'in Bearbeitung';
            case APPLICATION_STATUS_TYPE_BESTAETIGT:
                return 'bestätigt';
            case APPLICATION_STATUS_TYPE_ABGELEHNT:
                return 'abgelehnt';
            default:
                return 'unbekannt';
        }
    }
}
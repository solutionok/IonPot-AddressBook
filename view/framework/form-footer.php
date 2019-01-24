<?php
/**
 * should be included just before closing a form element
 * this should be use when the form method type is POST
 *
 * @version 1.0
 */
$antiCSRF->insertHiddenToken();

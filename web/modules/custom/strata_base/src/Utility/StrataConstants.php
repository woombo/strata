<?php

declare(strict_types=1);

namespace Drupal\strata_base\Utility;

/**
 * Constants for Strata modules.
 */
class StrataConstants {

  /**
   * Strata role IDs.
   */
  public const ROLE_ADMIN = 'strata_admin';
  public const ROLE_MANAGER = 'strata_manager';
  public const ROLE_COUNCIL = 'strata_council';
  public const ROLE_STAFF = 'strata_staff';
  public const ROLE_RESIDENT = 'strata_resident';

  /**
   * All Strata roles.
   */
  public const ALL_ROLES = [
    self::ROLE_ADMIN,
    self::ROLE_MANAGER,
    self::ROLE_COUNCIL,
    self::ROLE_STAFF,
    self::ROLE_RESIDENT,
  ];

  /**
   * Administrative roles.
   */
  public const ADMIN_ROLES = [
    self::ROLE_ADMIN,
    self::ROLE_MANAGER,
  ];

  /**
   * Management roles (can perform various operations).
   */
  public const MANAGEMENT_ROLES = [
    self::ROLE_ADMIN,
    self::ROLE_MANAGER,
    self::ROLE_COUNCIL,
    self::ROLE_STAFF,
  ];

  /**
   * Ticket status constants.
   */
  public const TICKET_STATUS_OPEN = 'open';
  public const TICKET_STATUS_IN_PROGRESS = 'in_progress';
  public const TICKET_STATUS_RESOLVED = 'resolved';
  public const TICKET_STATUS_CLOSED = 'closed';
  public const TICKET_STATUS_CANCELLED = 'cancelled';

  /**
   * All ticket statuses.
   */
  public const TICKET_STATUSES = [
    self::TICKET_STATUS_OPEN,
    self::TICKET_STATUS_IN_PROGRESS,
    self::TICKET_STATUS_RESOLVED,
    self::TICKET_STATUS_CLOSED,
    self::TICKET_STATUS_CANCELLED,
  ];

  /**
   * Ticket priority constants.
   */
  public const TICKET_PRIORITY_LOW = 'low';
  public const TICKET_PRIORITY_MEDIUM = 'medium';
  public const TICKET_PRIORITY_HIGH = 'high';
  public const TICKET_PRIORITY_URGENT = 'urgent';

  /**
   * All ticket priorities.
   */
  public const TICKET_PRIORITIES = [
    self::TICKET_PRIORITY_LOW,
    self::TICKET_PRIORITY_MEDIUM,
    self::TICKET_PRIORITY_HIGH,
    self::TICKET_PRIORITY_URGENT,
  ];

  /**
   * Ticket type constants.
   */
  public const TICKET_TYPE_COMPLAIN = 'complain';
  public const TICKET_TYPE_REQUEST = 'request';
  public const TICKET_TYPE_COMMENTS = 'comments';

  /**
   * All ticket types.
   */
  public const TICKET_TYPES = [
    self::TICKET_TYPE_COMPLAIN,
    self::TICKET_TYPE_REQUEST,
    self::TICKET_TYPE_COMMENTS,
  ];

  /**
   * Permission constants for Strata modules.
   */
  public const PERMISSION_MANAGE_BUILDING = 'manage strata building';
  public const PERMISSION_MANAGE_FINANCES = 'manage strata finances';
  public const PERMISSION_MANAGE_MAINTENANCE = 'manage strata maintenance';
  public const PERMISSION_VIEW_REPORTS = 'view strata reports';
  public const PERMISSION_MANAGE_MEETINGS = 'manage strata meetings';
  public const PERMISSION_ACCESS_DASHBOARD = 'access strata dashboard';
  public const PERMISSION_MANAGE_COMMUNICATIONS = 'manage resident communications';
  public const PERMISSION_MANAGE_DOCUMENTS = 'manage building documents';
  public const PERMISSION_VIEW_DOCUMENTS = 'view building documents';
  public const PERMISSION_SUBMIT_MAINTENANCE = 'submit maintenance request';

  /**
   * Configuration keys.
   */
  public const CONFIG_BUILDING_INFO = 'strata_base.building_info';
  public const CONFIG_SETTINGS = 'strata_base.settings';

  /**
   * State keys for statistics.
   */
  public const STATE_STATS_PREFIX = 'strata_base.stats.';
  public const STATE_ACTIVE_RESIDENTS = 'strata_base.stats.active_residents';
  public const STATE_PENDING_TICKETS = 'strata_base.stats.pending_tickets';
  public const STATE_MAINTENANCE_REQUESTS = 'strata_base.stats.maintenance_requests';
  public const STATE_LAST_UPDATED = 'strata_base.stats.last_updated';

  /**
   * Date format constants.
   */
  public const DATE_FORMAT_SHORT = 'Y-m-d';
  public const DATE_FORMAT_MEDIUM = 'Y-m-d H:i';
  public const DATE_FORMAT_LONG = 'Y-m-d H:i:s';
  public const DATE_FORMAT_DISPLAY = 'F j, Y \a\t g:i A';

  /**
   * Entity bundle machine names.
   */
  public const BUNDLE_COMPLAIN = 'complain';
  public const BUNDLE_REQUEST = 'request';
  public const BUNDLE_COMMENTS = 'comments';

  /**
   * Category options for tickets.
   */
  public const CATEGORIES = [
    'maintenance' => 'Maintenance',
    'noise' => 'Noise',
    'parking' => 'Parking',
    'security' => 'Security',
    'cleanliness' => 'Cleanliness',
    'common_areas' => 'Common Areas',
    'building_facilities' => 'Building Facilities',
    'bylaw_violation' => 'Bylaw Violation',
    'plumbing' => 'Plumbing',
    'electrical' => 'Electrical',
    'hvac' => 'HVAC',
    'landscaping' => 'Landscaping',
    'other' => 'Other',
  ];

}
<?php

declare(strict_types=1);

namespace Drupal\strata_tickets\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Ticket type entity.
 *
 * @ConfigEntityType(
 *   id = "ticket_type",
 *   label = @Translation("Ticket type"),
 *   label_collection = @Translation("Ticket types"),
 *   label_singular = @Translation("ticket type"),
 *   label_plural = @Translation("ticket types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count ticket type",
 *     plural = "@count ticket types",
 *   ),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\strata_tickets\TicketTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\strata_tickets\Form\TicketTypeForm",
 *       "edit" = "Drupal\strata_tickets\Form\TicketTypeForm",
 *       "delete" = "Drupal\strata_tickets\Form\TicketTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\strata_tickets\TicketTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ticket_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "ticket",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/ticket_type/{ticket_type}",
 *     "add-form" = "/admin/structure/ticket_type/add",
 *     "edit-form" = "/admin/structure/ticket_type/{ticket_type}/edit",
 *     "delete-form" = "/admin/structure/ticket_type/{ticket_type}/delete",
 *     "collection" = "/admin/structure/ticket_type"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   }
 * )
 */
class TicketType extends ConfigEntityBundleBase implements TicketTypeInterface {

  /**
   * The Ticket type ID.
   */
  protected string $id;

  /**
   * The Ticket type label.
   */
  protected string $label;

  /**
   * The Ticket type description.
   */
  protected string $description;

  /**
   * {@inheritdoc}
   */
  public function getDescription(): string {
    return $this->description ?? '';
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription(string $description): TicketTypeInterface {
    $this->description = $description;
    return $this;
  }

}
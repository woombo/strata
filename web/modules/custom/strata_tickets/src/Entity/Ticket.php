<?php

declare(strict_types=1);

namespace Drupal\strata_tickets\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the Ticket entity.
 *
 * @ContentEntityType(
 *   id = "ticket",
 *   label = @Translation("Ticket"),
 *   label_collection = @Translation("Tickets"),
 *   label_singular = @Translation("ticket"),
 *   label_plural = @Translation("tickets"),
 *   label_count = @PluralTranslation(
 *     singular = "@count ticket",
 *     plural = "@count tickets",
 *   ),
 *   bundle_label = @Translation("Ticket type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\strata_tickets\TicketListBuilder",
 *     "views_data" = "Drupal\strata_tickets\Entity\TicketViewsData",
 *     "translation" = "Drupal\strata_tickets\TicketTranslationHandler",
 *     "form" = {
 *       "default" = "Drupal\strata_tickets\Form\TicketForm",
 *       "add" = "Drupal\strata_tickets\Form\TicketForm",
 *       "edit" = "Drupal\strata_tickets\Form\TicketForm",
 *       "delete" = "Drupal\strata_tickets\Form\TicketDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\strata_tickets\TicketHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\strata_tickets\TicketAccessControlHandler",
 *   },
 *   base_table = "ticket",
 *   translatable = TRUE,
 *   admin_permission = "administer ticket entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/ticket/{ticket}",
 *     "add-page" = "/ticket/add",
 *     "add-form" = "/ticket/add/{ticket_type}",
 *     "edit-form" = "/ticket/{ticket}/edit",
 *     "delete-form" = "/ticket/{ticket}/delete",
 *     "collection" = "/admin/content/tickets",
 *   },
 *   bundle_entity_type = "ticket_type",
 *   field_ui_base_route = "entity.ticket_type.edit_form"
 * )
 */
class Ticket extends ContentEntityBase implements TicketInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function getTitle(): string {
    return $this->get('title')->value ?? '';
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle(string $title): TicketInterface {
    $this->set('title', $title);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription(): string {
    return $this->get('description')->value ?? '';
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription(string $description): TicketInterface {
    $this->set('description', $description);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus(): string {
    return $this->get('ticket_status')->value ?? '';
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus(string $status): TicketInterface {
    $this->set('ticket_status', $status);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPriority(): string {
    return $this->get('priority')->value ?? '';
  }

  /**
   * {@inheritdoc}
   */
  public function setPriority(string $priority): TicketInterface {
    $this->set('priority', $priority);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime(): int {
    return (int) $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime(int $timestamp): TicketInterface {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the ticket entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the ticket entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDescription(t('The description of the ticket entity.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'text_default',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['ticket_status'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Status'))
      ->setDescription(t('The status of the ticket.'))
      ->setSettings([
        'allowed_values' => [
          'open' => 'Open',
          'in_progress' => 'In Progress',
          'resolved' => 'Resolved',
          'closed' => 'Closed',
          'cancelled' => 'Cancelled',
        ],
      ])
      ->setDefaultValue('open')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'list_default',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['priority'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Priority'))
      ->setDescription(t('The priority of the ticket.'))
      ->setSettings([
        'allowed_values' => [
          'low' => 'Low',
          'medium' => 'Medium',
          'high' => 'High',
          'urgent' => 'Urgent',
        ],
      ])
      ->setDefaultValue('medium')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'list_default',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
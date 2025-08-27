<?php

declare(strict_types=1);

namespace Drupal\strata_tickets\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Ticket entities.
 */
interface TicketInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Gets the ticket title.
   *
   * @return string
   *   Title of the ticket.
   */
  public function getTitle(): string;

  /**
   * Sets the ticket title.
   *
   * @param string $title
   *   The ticket title.
   *
   * @return \Drupal\strata_tickets\Entity\TicketInterface
   *   The called ticket entity.
   */
  public function setTitle(string $title): TicketInterface;

  /**
   * Gets the ticket description.
   *
   * @return string
   *   Description of the ticket.
   */
  public function getDescription(): string;

  /**
   * Sets the ticket description.
   *
   * @param string $description
   *   The ticket description.
   *
   * @return \Drupal\strata_tickets\Entity\TicketInterface
   *   The called ticket entity.
   */
  public function setDescription(string $description): TicketInterface;

  /**
   * Gets the ticket status.
   *
   * @return string
   *   Status of the ticket.
   */
  public function getStatus(): string;

  /**
   * Sets the ticket status.
   *
   * @param string $status
   *   The ticket status.
   *
   * @return \Drupal\strata_tickets\Entity\TicketInterface
   *   The called ticket entity.
   */
  public function setStatus(string $status): TicketInterface;

  /**
   * Gets the ticket priority.
   *
   * @return string
   *   Priority of the ticket.
   */
  public function getPriority(): string;

  /**
   * Sets the ticket priority.
   *
   * @param string $priority
   *   The ticket priority.
   *
   * @return \Drupal\strata_tickets\Entity\TicketInterface
   *   The called ticket entity.
   */
  public function setPriority(string $priority): TicketInterface;

  /**
   * Gets the ticket creation timestamp.
   *
   * @return int
   *   Creation timestamp of the ticket.
   */
  public function getCreatedTime(): int;

  /**
   * Sets the ticket creation timestamp.
   *
   * @param int $timestamp
   *   The ticket creation timestamp.
   *
   * @return \Drupal\strata_tickets\Entity\TicketInterface
   *   The called ticket entity.
   */
  public function setCreatedTime(int $timestamp): TicketInterface;

}
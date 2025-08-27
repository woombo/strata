<?php

declare(strict_types=1);

namespace Drupal\strata_tickets\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Ticket type entities.
 */
interface TicketTypeInterface extends ConfigEntityInterface {

  /**
   * Gets the Ticket type description.
   *
   * @return string
   *   The Ticket type description.
   */
  public function getDescription(): string;

  /**
   * Sets the Ticket type description.
   *
   * @param string $description
   *   The Ticket type description.
   *
   * @return \Drupal\strata_tickets\Entity\TicketTypeInterface
   *   The called Ticket type entity.
   */
  public function setDescription(string $description): TicketTypeInterface;

}
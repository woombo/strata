<?php

declare(strict_types=1);

namespace Drupal\strata_base\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\State\StateInterface;

/**
 * Service for managing building information.
 */
class StrataBuildingInfoService {

  /**
   * The config factory.
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * The state service.
   */
  protected StateInterface $state;

  /**
   * Constructs a StrataBuildingInfoService object.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    StateInterface $state
  ) {
    $this->configFactory = $config_factory;
    $this->state = $state;
  }

  /**
   * Gets building information.
   *
   * @return array
   *   Array of building information.
   */
  public function getBuildingInfo(): array {
    $config = $this->configFactory->get('strata_base.building_info');
    
    return [
      'name' => $config->get('name') ?? '',
      'address' => $config->get('address') ?? '',
      'city' => $config->get('city') ?? '',
      'postal_code' => $config->get('postal_code') ?? '',
      'province' => $config->get('province') ?? '',
      'country' => $config->get('country') ?? 'Canada',
      'total_units' => $config->get('total_units') ?? 0,
      'floors' => $config->get('floors') ?? 0,
      'built_year' => $config->get('built_year') ?? 0,
      'property_manager' => $config->get('property_manager') ?? '',
      'emergency_contact' => $config->get('emergency_contact') ?? '',
    ];
  }

  /**
   * Sets building information.
   *
   * @param array $info
   *   Array of building information.
   */
  public function setBuildingInfo(array $info): void {
    $config = $this->configFactory->getEditable('strata_base.building_info');
    
    $allowed_keys = [
      'name', 'address', 'city', 'postal_code', 'province', 'country',
      'total_units', 'floors', 'built_year', 'property_manager', 'emergency_contact'
    ];
    
    foreach ($allowed_keys as $key) {
      if (isset($info[$key])) {
        $config->set($key, $info[$key]);
      }
    }
    
    $config->save();
  }

  /**
   * Gets a specific building info value.
   *
   * @param string $key
   *   The info key.
   *
   * @return mixed
   *   The info value, or NULL if not found.
   */
  public function getBuildingInfoValue(string $key) {
    $info = $this->getBuildingInfo();
    return $info[$key] ?? NULL;
  }

  /**
   * Gets building statistics.
   *
   * @return array
   *   Array of building statistics.
   */
  public function getBuildingStats(): array {
    // These could be stored in state for performance
    return [
      'active_residents' => $this->state->get('strata_base.stats.active_residents', 0),
      'pending_tickets' => $this->state->get('strata_base.stats.pending_tickets', 0),
      'maintenance_requests' => $this->state->get('strata_base.stats.maintenance_requests', 0),
      'last_updated' => $this->state->get('strata_base.stats.last_updated', time()),
    ];
  }

  /**
   * Updates building statistics.
   *
   * @param array $stats
   *   Array of statistics to update.
   */
  public function updateBuildingStats(array $stats): void {
    foreach ($stats as $key => $value) {
      $this->state->set("strata_base.stats.$key", $value);
    }
    
    $this->state->set('strata_base.stats.last_updated', time());
  }

}
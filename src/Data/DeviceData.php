<?php
/**
 * Gustav HmIPHP - An interface for communication with a Homematic CCU
 * Copyright (C) since 2020  Gustav Software
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Gustav\HmIPHP\Data;

use Gustav\Cache\CacheException;
use Gustav\HmIPHP\Connection\ConnectionException;
use Gustav\HmIPHP\Utils\Container;
use Psr\Cache\InvalidArgumentException;

/**
 * This class represents the data of some device
 *
 * @author Chris Köcher <ckone@fieselschweif.de>
 * @link   https://gustav.fieselschweif.de
 * @since  1.0.0
 */
class DeviceData extends AData
{
    /**
     * The identifier of this device.
     *
     * @var string
     */
    private string $_id;

    /**
     * Constructor of this class.
     *
     * @param Container $container
     *   The container
     * @param string $id
     *   The identifier
     */
    public function __construct(Container $container, string $id)
    {
        parent::__construct($container);
        $this->_id = $id;
    }

    /**
     * Returns the identifier of this device.
     *
     * @return string
     *   The identifier
     */
    public function getId(): string
    {
        return $this->_id;
    }

    /**
     * Returns the type name of this device.
     *
     * @return string
     *   The type
     * @throws CacheException
     *   Some error occurred while handling the cached data
     * @throws ConnectionException
     *   Some HTTP error code occurred
     * @throws InvalidArgumentException
     *   Some invalid argument was given to the cache
     */
    public function getType(): string
    {
        return $this->_container->getMapping()->getDeviceData($this->_id)['type'];
    }

    /**
     * Returns the name of this device.
     *
     * @return string
     *   The name
     * @throws CacheException
     *   Some error occurred while handling the cached data
     * @throws ConnectionException
     *   Some HTTP error code occurred
     * @throws InvalidArgumentException
     *   Some invalid argument was given to the cache
     */
    public function getName(): string
    {
        return $this->_container->getMapping()->getDeviceData($this->_id)['name'];
    }

    /**
     * Returns the version of the firmware of this device.
     *
     * @return string
     *   The version of the firmware
     * @throws CacheException
     *   Some error occurred while handling the cached data
     * @throws ConnectionException
     *   Some HTTP error code occurred
     * @throws InvalidArgumentException
     *   Some invalid argument was given to the cache
     */
    public function getFirmware(): string
    {
        return $this->_container->getMapping()->getDeviceData($this->_id)['firmware'];
    }

    /**
     * Indicates whether this device's communication with the CCU is secure.
     *
     * @return bool
     *   true, if secure, false otherwise
     * @throws CacheException
     *   Some error occurred while handling the cached data
     * @throws ConnectionException
     *   Some HTTP error code occurred
     * @throws InvalidArgumentException
     *   Some invalid argument was given to the cache
     */
    public function isSecured(): bool
    {
        return $this->_container->getMapping()->getDeviceData($this->_id)['secured'];
    }

    /**
     * Returns a list of all channels of this device.
     *
     * @return ChannelData[]
     *   The channels
     * @throws CacheException
     *   Some error occurred while handling the cached data
     * @throws ConnectionException
     *   Some HTTP error code occurred
     * @throws InvalidArgumentException
     *   Some invalid argument was given to the cache
     */
    public function getChannels(): iterable
    {
        yield from $this->_container->getMapping()->getChannels($this->_id);
    }

    /**
     * Returns the channel with the given number.
     *
     * @param int $id
     *   The channel number
     * @return ChannelData
     *   The channel
     * @throws CacheException
     *   Some error occurred while handling the cached data
     * @throws ConnectionException
     *   Some HTTP error code occurred
     * @throws InvalidArgumentException
     *   Some invalid argument was given to the cache
     */
    public function getChannel(int $id): ChannelData
    {
        return $this->_container->getMapping()->getChannel($this->_id . "/" . $id);
    }
}
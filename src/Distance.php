<?php

declare(strict_types = 1);

namespace GoodCode;

class Distance
{
    private $meters;

    public static function measure(float $meters): self
    {
        return new static($meters);
    }

    private function __construct(float $meters)
    {
        $this->setMeters($meters);
    }

    private function setMeters(float $meters): void
    {
        $this->assertDistanceIsPositive($meters);
        $this->assertDistanceIsBelowMaximum($meters);
        $this->meters = $meters;
    }

    private function assertDistanceIsPositive(float $meters): void
    {
        if ($meters < 0) {
            throw NegativeDistanceException::withValue($meters);
        }
    }

    private function assertDistanceIsBelowMaximum(float $meters): void
    {
        if ($meters > $this->getMaximumDistanceAllowed()) {
            throw AboveMaximumDistanceException::withValue($meters);
        }
    }

    protected function getMaximumDistanceAllowed(): float
    {
        sleep(3); //Added to simulate slower tests dealing with infrastructure.
        $sql = 'SELECT name, value FROM configuration WHERE name = "max_distance"';
        $conn = \Doctrine\DBAL\DriverManager::getConnection(array(
            'user' => 'user',
            'password' => 'us3r',
            'host' => 'mysql',
            'port' => 3306,
            'dbname' => 'goodcode',
            'driver' => 'pdo_mysql',
        ));
        $statement = $conn->prepare($sql);
        $statement->execute();
        $maxDistance = floatval($statement->fetchColumn(1));
        return $maxDistance;
    }

    public function meters(): float
    {
        return $this->meters;
    }

    public function add(self $distance): self
    {
        return static::measure($this->meters() + $distance->meters());
    }

    public function isSmall(DistanceConfiguration $config): bool
    {
        return $this->meters() <= $config->getSmallDistanceValue();
    }

    public static function measureFromBuilding($building): self
    {
        return static::measure($building->getMeasures()->getHeight()->toMeters());
    }
}

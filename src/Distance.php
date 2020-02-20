<?php

declare(strict_types = 1);

namespace GoodCode;


class Distance
{
    private $meters;

    public function setMeters(float $meters): void
    {
        if ($meters >= 0) {
            $sql = 'SELECT name, value FROM configuration WHERE name = "max_distance"';
            $conn = \Doctrine\DBAL\DriverManager::getConnection(array(
                'user' => 'root',
                'password' => 'examplepassword',
                'host' => '127.0.0.1',
                'port' => 3306,
                'dbname' => 'goodcode',
                'driver' => 'pdo_mysql',
            ));
            $statement = $conn->prepare($sql);
            $statement->execute();
            $maxDistance = floatval($statement->fetchColumn(1));

            if ($meters > $maxDistance) {
                throw new AboveMaximumDistanceException("Distance is above the maximum allowed value");
            }
            $this->meters = $meters;
        } else {
            throw new NegativeDistanceException("Distance must be positive");
        }
    }

    public function meters(): float
    {
        return $this->meters;
    }

    public function add(Distance $distance): Distance
    {
        $this->meters = $this->meters() + $distance->meters();
        return $this;
    }

    public function isSmall(DistanceConfiguration $config): bool
    {
        return $this->meters() <= $config->getSmallDistanceValue();
    }

    public function setMetersFromBuilding($building): void
    {
        $this->setMeters($building->getMeasures()->getHeight()->toMeters());
    }
}

<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

use Robo\Tasks;

final class RoboFile extends Tasks
{
    public function testAcceptance($phiremockPort = '8080', $phiremockInterface = '0.0.0.0')
    {
        $this->taskExec(sprintf('phiremock -p %s -i %s', $phiremockPort, $phiremockInterface))
            ->background(true)
            ->run();

        $this->taskPHPUnit()
            ->bootstrap('tests/bootstrap.php')
            ->run();
    }
}
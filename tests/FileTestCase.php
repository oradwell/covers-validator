<?php

namespace OckCyp\CoversValidator\Tests;

abstract class FileTestCase extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->preTestRun();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->postTestRun();
    }
}

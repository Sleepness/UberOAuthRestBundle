<?php

namespace Sleepness\UberOAuthRestBundle\Tests\Provider;

class BaseOAuthProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  @dataProvider urlProvider
     */
    public function testNormilizeUrl($url, $params, $expected)
    {
        $stub = $this->getMockBuilder('Sleepness\UberOAuthRestBundle\Provider\BaseOAuthProvider')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $stub
            ->expects($this->any())
            ->method('normalizeUrl')
        ;

        $this->assertEquals($expected, $this->invokeMethod($stub, 'normalizeUrl', [$url, $params]));
    }

    public function urlProvider()
    {
        return [
            ['http://vk.com', [], 'http://vk.com'],
            ['http://vk.com', ['a' => 'aa'], 'http://vk.com?a=aa'],
            ['http://vk.com?b=bb', ['a' => 'aa'], 'http://vk.com?b=bb&a=aa'],
        ];
    }

    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}

<?php
namespace Particle\Tests\Rule;

use Particle\Validator\Rule\Numeric;
use Particle\Validator\Validator;

class NumericTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Validator
     */
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    /**
     * @dataProvider getValidNumericValues
     * @param mixed $value
     */
    public function testReturnsTrueOnValidInteger($value)
    {
        $this->validator->required('number')->numeric();
        $this->assertTrue($this->validator->validate(['number' => $value]));
    }

    /**
     * @dataProvider getInvalidNumericValues
     * @param string $value
     */
    public function testReturnsFalseOnInvalidIntegers($value)
    {
        $this->validator->required('number')->numeric();
        $this->assertFalse($this->validator->validate(['number' => $value]));

        $expected = [
            'number' => [
                Numeric::NOT_NUMERIC => $this->getMessage(Numeric::NOT_NUMERIC)
            ]
        ];
        $this->assertEquals($expected, $this->validator->getMessages());
    }

    public function getValidNumericValues()
    {
        return [
            ['133.7'],
            [133.7],
            ['1337'],
            ['1211'],
            ['0'],
            [1231],
            [-12],
            ['-12'],
            [0xFF],
        ];
    }

    public function getInvalidNumericValues()
    {
        return [
            ['a1211'],
            ['not even a number in sight!']
        ];
    }

    public function getMessage($reason)
    {
        $messages = [
            Numeric::NOT_NUMERIC => 'number must be numeric'
        ];

        return $messages[$reason];
    }
}
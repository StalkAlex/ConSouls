<?php
namespace RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Profile;
use RPGBundle\Exception\AbsentProfileException;
use RPGBundle\Exception\ProfileValidationException;
use RPGBundle\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Class ProfileServiceTest
 */
class ProfileServiceTest extends TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject $emMock */
    private $emMock;
    /** @var  \PHPUnit_Framework_MockObject_MockObject $emMock */
    private $validatorMock;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->emMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->validatorMock = $this->getMockBuilder(RecursiveValidator::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test valid creating profile
     */
    public function testCreateProfileValid()
    {
        //it should call validation method with valid profile instance
        //then it should call db saving methods
        $this->emMock->expects($this->once())
            ->method('persist')
            ->willReturn(true);
        $this->emMock->expects($this->once())
            ->method('flush')
            ->willReturn(true);
        $this->validatorMock->expects($this->any())
            ->method('validate')
            ->willReturnCallback(function (Profile $profile) {
                $this->assertEquals('Tester', $profile->getName());
                $this->assertEquals('Knight', $profile->getHeroName());
            });
        $profileService = new ProfileService($this->emMock, $this->validatorMock);
        $profileService->createProfile('Tester', 'Knight');
    }

    /**
     * Test creating without name
     */
    public function testCreateProfileException()
    {
        //saving will not be invoked
        $this->emMock->expects($this->never())
            ->method('persist')
            ->willReturn(true);
        $this->emMock->expects($this->never())
            ->method('flush')
            ->willReturn(true);
        //we return 1 error from validation method
        $this->validatorMock->expects($this->any())
            ->method('validate')
            ->willReturn(1);
        $this->expectException(ProfileValidationException::class);
        $profileService = new ProfileService($this->emMock, $this->validatorMock);
        $profileService->createProfile('', 'Knight');
    }

    /**
     * Test if valid profile list could be returned from repository
     */
    public function testGetProfilesExists()
    {
        $profiles = [
            new Profile(),
            new Profile(),
        ];
        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $profileRepositoryMock ->expects($this->once())
            ->method('findAll')
            ->willReturn($profiles);
        $this->emMock->expects($this->once())
            ->method('getRepository')
            ->willReturn($profileRepositoryMock);
        $profileService = new ProfileService($this->emMock, $this->validatorMock);
        $this->assertCount(2, $profileService->getProfiles());
    }

    /**
     * Test if empty array will be returned for empty repository
     */
    public function testGetProfilesEmpty()
    {
        $profiles = [];
        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $profileRepositoryMock ->expects($this->once())
            ->method('findAll')
            ->willReturn($profiles);
        $this->emMock->expects($this->once())
            ->method('getRepository')
            ->willReturn($profileRepositoryMock);
        $profileService = new ProfileService($this->emMock, $this->validatorMock);
        $this->assertCount(0, $profileService->getProfiles());
    }

    /**
     * Test if valid instance could be retrieved from repository
     */
    public function testGetProfile()
    {
        $profile = new Profile();
        $profile->setName('Tester');
        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $profileRepositoryMock ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($profile);
        $this->emMock->expects($this->once())
            ->method('getRepository')
            ->willReturn($profileRepositoryMock);
        $profileService = new ProfileService($this->emMock, $this->validatorMock);
        $profileFromService = $profileService->getProfile('test');
        $this->assertInstanceOf(Profile::class, $profileFromService);
        $this->assertSame('Tester', $profileFromService->getName());
    }

    /**
     * Test exception if there is no profile with this name in repository
     */
    public function testGetProfileException()
    {
        $this->expectException(AbsentProfileException::class);
        $profileRepositoryMock = $this->getMockBuilder(ProfileRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        //repository will return null intead of profile instance
        $profileRepositoryMock ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);
        $this->emMock->expects($this->once())
            ->method('getRepository')
            ->willReturn($profileRepositoryMock);
        $profileService = new ProfileService($this->emMock, $this->validatorMock);
        $profileService->getProfile('test');
    }
}

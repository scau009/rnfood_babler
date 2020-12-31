<?php


namespace App\Command\Dev;


use App\Entity\Trades;
use App\Repository\TradesRepository;
use App\Service\Coupon\CouponService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DevPayNotifyCommand extends Command
{
    protected static $defaultName = "dev:pay-notify";

    private EntityManagerInterface $em;

    private TradesRepository $tradeRepo;

    private CouponService $couponService;

    public function __construct(EntityManagerInterface $entityManager,CouponService $couponService)
    {
        parent::__construct(null);
        $this->em = $entityManager;
        $this->tradeRepo = $entityManager->getRepository(Trades::class);
        $this->couponService = $couponService;
    }

    protected function configure()
    {
        $this->addArgument("tid",InputArgument::REQUIRED,"交易号");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $trade = $this->tradeRepo->findOneByTid($input->getArgument('tid'));
        $trade->setPayAt(new \DateTime()); // 更新支付时间为当前时间
        $trade->setStatus(Trades::STATUS_PAID);
        //生成优惠券
        $this->couponService->createCouponByTrade($trade);
        return Command::SUCCESS;
    }
}
<?php

namespace App\Command;

use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Services\InvoiceService;

class generateInvoicesCommand extends Command
{
    protected static $defaultName = 'export';

    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
        	->setDescription('Export invoices for a delivery man by year')
        	->addArgument('deliveryManId', InputArgument::REQUIRED, 'The delivery man you want to generate for')
        	->addArgument('date', InputArgument::REQUIRED, 'The date you want to generate for')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$deliveryManId = (int) $input->getArgument('deliveryManId');
    	$date = $input->getArgument('date');
    	$date = new DateTimeImmutable($date);
    	$this->invoiceService->export($deliveryManId, $date);
    }
}
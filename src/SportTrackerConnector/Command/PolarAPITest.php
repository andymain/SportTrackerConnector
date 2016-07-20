<?php

namespace SportTrackerConnector\Command;

use InvalidArgumentException;
use SportTrackerConnector\Tracker\Polar\Tracker as PolarTracker;
use SportTrackerConnector\Tracker\Polar\API as PolarAPI;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use PSR\Log\LoggerInterface as Logger;
use DateTime;
use GuzzleHttp\Client;
use RuntimeException;
use SportTrackerConnector\Core\Workout\SportMapperInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Fetch a workout from a tracker and dump it to a file.
 */
class PolarAPITest extends AbstractCommand
{

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        parent::configure();
        $cwd = getcwd() . DIRECTORY_SEPARATOR;
        $this->setName('polarapitest')
            ->setDescription('Fetch a workout from a tracker and save it to a file.');

    }

    /**
     * Run the command.
     *
     * @return integer
     * @throws InvalidArgumentException If the input file is not readable or the output file is not writable.
     */
    protected function runCommand()
    {

        $startDate = new \DateTime('yesterday');
        $endDate = new \DateTime('today');

        $config = Yaml::parse(file_get_contents('config.yml'), true);

        $client = new Client();
        $client->setDefaultOption('verify', false);

        $polarAPI = new PolarAPI($client, $config['polar']['auth']['username'], $config['polar']['auth']['password']);
        $list = $polarAPI->listActivitySummary($startDate, $endDate);

        print_r($list);

    }

}

<?php
//Logger
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as LogWriterStream;
use Zend\Log\Formatter\Simple as LogFormatter;

return array(
    'factories' => array(
        
        //Logger
        'Zend\Log' => function ($sm) {
            $filename = 'log_' . date('m-Y') . '.txt';
            $log = new Logger();
            $writer = new LogWriterStream('./data/logs/' . $filename);

            //Formatter
            $format = '[%timestamp%] %priorityName%: %message%';
            $formatter = new LogFormatter($format);
            $formatter->setDateTimeFormat("d/m/Y H:i:s");
            $writer->setFormatter($formatter);

           $log->addWriter($writer);
           return $log;
       },
    ),
);

<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Corerq;

/**
 */
class SayClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Corerq\CoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function check(\Corerq\CoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/corerq.Say/check',
        $argument,
        ['\Corerq\CoreResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Corerq\ParambySerial $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function scrutingSerial(\Corerq\ParambySerial $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/corerq.Say/scrutingSerial',
        $argument,
        ['\Corerq\StateOne', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Corerq\ParamScruttinAll $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function scrutingAll(\Corerq\ParamScruttinAll $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/corerq.Say/scrutingAll',
        $argument,
        ['\Corerq\StateAll', 'decode'],
        $metadata, $options);
    }

}

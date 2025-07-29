<?php
// websocket-server.php

require __DIR__ . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\WebSockets\VehicleTrackingHandler;

class VehicleTrackingHandler implements \Ratchet\MessageComponentInterface {
    protected $clients;
    protected $vehicleSubscriptions;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->vehicleSubscriptions = [];
    }

    public function onOpen(\Ratchet\ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(\Ratchet\ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        
        if ($data && isset($data['action'])) {
            switch ($data['action']) {
                case 'subscribe':
                    $vehicleId = $data['vehicle_id'];
                    $this->vehicleSubscriptions[$vehicleId][] = $from;
                    echo "Client {$from->resourceId} subscribed to vehicle {$vehicleId}\n";
                    break;
                
                case 'unsubscribe':
                    $vehicleId = $data['vehicle_id'];
                    if (isset($this->vehicleSubscriptions[$vehicleId])) {
                        $this->vehicleSubscriptions[$vehicleId] = array_filter(
                            $this->vehicleSubscriptions[$vehicleId],
                            function($conn) use ($from) {
                                return $conn !== $from;
                            }
                        );
                    }
                    break;
            }
        }
    }

    public function onClose(\Ratchet\ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
        
        // Clean up any subscriptions
        foreach ($this->vehicleSubscriptions as $vehicleId => $connections) {
            $this->vehicleSubscriptions[$vehicleId] = array_filter(
                $connections,
                function($c) use ($conn) {
                    return $c !== $conn;
                }
            );
        }
    }

    public function onError(\Ratchet\ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    // Call this method from your controller to broadcast updates
    public function broadcastPositionUpdate($vehicleId, $lat, $lng) {
        if (isset($this->vehicleSubscriptions[$vehicleId])) {
            $message = json_encode([
                'vehicle_id' => $vehicleId,
                'latitude' => $lat,
                'longitude' => $lng,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
            foreach ($this->vehicleSubscriptions[$vehicleId] as $client) {
                $client->send($message);
            }
        }
    }
}

// Run the server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new VehicleTrackingHandler()
        )
    ),
    8080
);

echo "WebSocket server running on port 8080\n";
$server->run();
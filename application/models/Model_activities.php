<?php
	/**
	* 
	*/
	require_once '/google-api-php-client-master/autoload.php';
	class Model_activities extends CI_Model
	{
		public function __construct() {
			$this->inicializarCalendar();
		}
		public function create( $post ) {
			$event = new Google_Service_Calendar_Event();
			$event->setSummary( $post['summary'] );
			$event->setLocation( $post['location'] );
			$event->setDescription( $post['description'] );
			$event->setVisibility('public');

			$start = new Google_Service_Calendar_EventDateTime();
			$end = new Google_Service_Calendar_EventDateTime();

			if ( isset($post['allDay']) ) {
				// var_dump($post);die();
				// $start->setTimeZone('America/Mexico_City');
				$start->setDate( $post['start'] );
				// $end->setTimeZone('America/Mexico_City');
				$end->setDate( $post['end'] );
			}else{
				// var_dump($post);die();
				$start->setTimeZone('America/Mexico_City');
				$start->setDateTime( $post['start'] );
				$end->setTimeZone('America/Mexico_City');
				$end->setDateTime( $post['end'] );
			}

			$event->setStart( $start );
			$event->setEnd( $end );

			if ( isset($post['attendees']) && $post['attendees'] ) {
				$attendees = $event->attendees = $post['attendees'];
			}

			$createdEvent = $this->service->events->insert('f3i1som6133f9j4ul5an2radko@group.calendar.google.com', $event);
			
			if ( $createdEvent ) {
				return $this->get( $createdEvent->getId() );
			} else {
				return 'error';
			}
		}
		public function get( $id = false ) {
	        $calendarId = 'f3i1som6133f9j4ul5an2radko@group.calendar.google.com';

			if ( $id ) {
				$event 	= $this->service->events->get($calendarId,$id);
				$event->start 	= $event->getStart();
	            $event->end 	= $event->getEnd();
				
	            return $this->output->set_output(json_encode( $event ));
	        } else {
	            $events = $this->service->events->listEvents($calendarId);
	            $arrayEvents = [];
	            while (true) {
	            	foreach ($events->getItems() as $event) {
	            		$event->start = $event->getStart();
	            		$event->end = $event->getEnd();

	            		array_push( $arrayEvents, $event );
	            		
	            	}
	            	$pageToken = $events->getNextPageToken();
	            	if ( $pageToken ) {
	            		# code...
	            	} else {
	            		break;
	            	}
	            	
	            }
	            return $this->output->set_output(json_encode( $arrayEvents ));
	        }
		}
		public function save( $id,  $put ) {}
		
		public function destroy( $id ) {
			var_dump($id);
			$calendarId = 'f3i1som6133f9j4ul5an2radko@group.calendar.google.com';
			return $this->service->events->delete($calendarId,$id);
		}

	    private function inicializarCalendar () {
	        $client_id = '266013765630-no4316pgdf96q34c98eb0bit2or9ff0s.apps.googleusercontent.com';
	        $client_secret = '9eMzpa4ags-xnvzPkEGEqrFs';
	        $redirect_uri = 'http://crmqualium.com/escritorio/conectar';

	        $this->client = new Google_Client();
	        $this->client->setClientId($client_id);
	        $this->client->setClientSecret($client_secret);
	        $this->client->setRedirectUri($redirect_uri);
	        $this->client->addScope("https://www.googleapis.com/auth/calendar");

	        $this->service = new Google_Service_Calendar($this->client);
	    }
	}
?>
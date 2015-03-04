<?php
	/**
	* El calendario de google de los invitados debe estar en la zona horaria
	* de la ciudad de México par que los eventos no se muestren con un día de
	* atraso o de adelanto.
	*/
	require_once '/google-api-php-client-master/autoload.php';
	class Model_activities extends CI_Model {
		public function __construct() {
			$this->inicializarCalendar();
		}
		public function create( $post, $update = false ) {
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
				$attendees = [];
				if ( is_array( $post['attendees'] ) ) {
					foreach ($post['attendees'] as $email) {
						$attendee = new Google_Service_Calendar_EventAttendee();
						$attendee->setEmail( $email );
						array_push( $attendees, $attendee );
					}
				} else {
					$attendee = new Google_Service_Calendar_EventAttendee();
					$attendee->setEmail( $post['attendees'] );
					array_push( $attendees, $attendee );
				}

				$event->attendees = $attendees;
			}

			if ( $update ) {
				return $event;
			}

			$createdEvent = $this->service->events->insert('f3i1som6133f9j4ul5an2radko@group.calendar.google.com',,TRUE, $event);
			
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
				
				$event = $this->obtenerPropiedades($event);
				
	            return $this->output->set_output(json_encode( $event ));
	        } else {
	            $events = $this->service->events->listEvents($calendarId);
	            $arrayEvents = [];
	            while (true) {
	            	foreach ($events->getItems() as $event) {
	            		
	            		$event = $this->obtenerPropiedades($event);

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
		public function obtenerPropiedades ($event) {
			$event->start = $event->getStart();
			$event->end = $event->getEnd();
			$event->attendees = $event->getAttendees();
			$event->creator = $event->getCreator();
			return $event;
		}
		public function save( $put, $id ) {
			$calendarId = 'f3i1som6133f9j4ul5an2radko@group.calendar.google.com';

			$event = $this->create($put, true);
			$event = $this->service->events->update($calendarId, $id, $event);
			if ( $event ) {
				return $this->get( $id );
			} else {
				return 'error';
			}
		}
		public function destroy( $id ) {
			$calendarId = 'f3i1som6133f9j4ul5an2radko@group.calendar.google.com';
			$resp = $this->service->events->delete($calendarId,$id);
			return $this->output->set_output(json_encode( $resp ));
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
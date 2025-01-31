<? class EventController {
    private $eventModel;
    private $calendarView;

    public function __construct($eventModel, $calendarView) {
        $this->eventModel = $eventModel;
        $this->calendarView = $calendarView;
    }

    public function showEvents($month, $year) {
        $events = $this->eventModel->getEvents($month, $year);
        $this->calendarView->show($month, $year, $events);
    }

    public function createEvent($month, $year) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $date = $_POST['date'];
            $description = $_POST['description'];
            $this->eventModel->createEvent($title, $date, $description);
            header("Location: index.php?/Calendar/show/{$month}/{$year}"); 
            exit;
        }
    }
}

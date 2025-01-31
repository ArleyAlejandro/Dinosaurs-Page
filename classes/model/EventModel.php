<?
class EventModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getEvents($month, $year) {
        $sql = "SELECT * FROM events WHERE MONTH(event_date) = ? AND YEAR(event_date) = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$month, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($title, $date, $description) {
        $sql = "INSERT INTO events (event_title, event_date, event_description) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $date, $description]);
    }
}

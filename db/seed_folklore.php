<?php
require_once __DIR__ . '/../config/db.php';

$stories = [
    [
        'title' => 'The Dragon Painter',
        'culture' => 'Chinese',
        'moral' => 'Some finishing touches carry more power than we are ready to believe.',
        'parts' => [
            "A renowned painter was asked to decorate a temple wall with four great dragons. He painted them with astonishing skill, every scale and claw alive with motion, but he refused to paint their eyes. When people asked why, he warned them that if he gave the dragons sight, they would wake and fly away. The townspeople laughed this off as an excuse, certain the old man simply wanted an easy way out of finishing the work.",
            "Stung by their doubt, the painter finally agreed to prove himself. He lifted his brush and, with two careful strokes, painted eyes onto two of the four dragons. At once the sky darkened, thunder rolled through the temple, and the two dragons tore themselves free of the wall, climbing into the storm and vanishing from sight. The two dragons left without eyes remained exactly where they were, flat and still on the stone, exactly as they are said to remain to this day."
        ]
    ],
    [
        'title' => 'Anansi and the Calabash of Wisdom',
        'culture' => 'West African (Anansi tales)',
        'moral' => 'Wisdom kept for one person alone stops being wisdom at all.',
        'parts' => [
            "Anansi the spider decided the world held far too much wisdom for ordinary people to be trusted with. One by one, he gathered every wise thought he could find and sealed them all inside a great calabash gourd. His plan was simple: carry the calabash to the very top of the tallest tree in the forest, where no one else would ever be able to reach it, leaving him the only wise creature left in the world.",
            "Anansi tied the calabash to the front of his body and began to climb, but the round gourd kept knocking against the trunk, blocking his own legs and slowing him at every branch. His young son, watching from below, called up that the climb would go easier if he tied the calabash to his back instead. Furious that even his own child had outwitted him so easily, Anansi realized that wisdom hoarded away from everyone else had never really been wisdom to begin with. He climbed back down and let the calabash fall, shattering at the tree's roots and scattering its contents to the wind, where wisdom has belonged to everyone, a little at a time, ever since."
        ]
    ],
    [
        'title' => 'The Farmer and the Golden Goose',
        'culture' => 'Aesop tradition (as carried through Bengali retellings)',
        'moral' => 'Chasing everything at once often costs you everything you already had.',
        'parts' => [
            "A poor farmer once discovered that his goose laid a single golden egg every morning, without fail. He sold each egg for a fair price, and within a season his family had moved from hunger to real comfort for the first time in their lives. But comfort, once tasted, only sharpened his appetite for more, and he grew impatient waiting for the gold to arrive one small egg at a time.",
            "Certain that a goose capable of producing gold each morning must be filled with gold inside, the farmer took a knife and cut the bird open to claim it all at once. He found nothing but the ordinary insides of an ordinary goose, now dead, and no more eggs, golden or otherwise, ever came again. In trying to seize an entire fortune in a single moment, he had traded away the slow, certain wealth he already held."
        ]
    ],
];

$storyStmt = $conn->prepare("INSERT INTO folklore_stories (title, culture, total_parts, moral) VALUES (?, ?, ?, ?)");
$partStmt = $conn->prepare("INSERT INTO folklore_parts (story_id, part_number, content) VALUES (?, ?, ?)");

foreach ($stories as $story) {
    $totalParts = count($story['parts']);
    $storyStmt->bind_param("ssis", $story['title'], $story['culture'], $totalParts, $story['moral']);
    $storyStmt->execute();
    $storyId = $conn->insert_id;

    foreach ($story['parts'] as $index => $content) {
        $partNumber = $index + 1;
        $partStmt->bind_param("iis", $storyId, $partNumber, $content);
        $partStmt->execute();
    }

    echo "Seeded: {$story['title']} ({$totalParts} parts)\n";
}

echo "Done.\n";

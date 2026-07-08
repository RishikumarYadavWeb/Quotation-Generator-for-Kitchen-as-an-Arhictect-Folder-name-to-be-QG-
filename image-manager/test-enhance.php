<?php

require_once __DIR__ . "/helpers/OpenAI.php";
require_once __DIR__ . "/helpers/prompt.php";

$image = __DIR__ . "/sample.png";

$result = enhanceWithGemini(
    $image,
    getRenderEnhancementPrompt()
);

echo "<pre>";
print_r($result);
echo "</pre>";
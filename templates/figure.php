<?php
declare(strict_types=1);

$context = $this->get('context', 'figure');

\ItalyStrap\HTML\open_tag_e($context, 'figure', []);
echo $this->get('innerContent');
\ItalyStrap\HTML\close_tag_e($context);

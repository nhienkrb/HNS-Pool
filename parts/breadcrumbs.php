<?php
$breadcrumbs = Breadcrumbs::generate();
?>

<section class="bg-[#F8F8F8]">
    <div class="container mx-auto px-4">
        <nav class="flex py-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">

                <?php foreach ($breadcrumbs as $index => $item): ?>

                    <li class="inline-flex items-center">
                        <?php if (!empty($item['url'])): ?>
                            <a href="<?= $item['url']; ?>"
                               class="text-sm font-medium text-gray-700 hover:text-blue-600">
                                <?= esc_html($item['label']); ?>
                            </a>
                        <?php else: ?>
                            <span class="text-sm font-medium text-gray-500">
                                <?= esc_html($item['label']); ?>
                            </span>
                        <?php endif; ?>
                    </li>

                    <?php if ($index < count($breadcrumbs) - 1): ?>
                        <li>
                            <svg class="w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-width="1"
                                      d="m1 9 4-4-4-4"/>
                            </svg>
                        </li>
                    <?php endif; ?>

                <?php endforeach; ?>

            </ol>
        </nav>
    </div>
</section>

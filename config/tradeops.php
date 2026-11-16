<?php

return [
    /*
     | Material id treated as "salary" in the legacy accounting page.
     | Rows with this material are shown with a salary multiplier.
     */
    'salary_material_id' => (int) env('TRADEOPS_SALARY_MATERIAL_ID', 57),

    'accounting_per_page' => (int) env('TRADEOPS_ACCOUNTING_PER_PAGE', 50),

    'machine_image_dir' => 'img',
];

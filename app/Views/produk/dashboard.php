<?= $this->section('title'); ?>
<?= $title; ?>
<?= $this->endSection(); ?>

<?php if (in_groups('admin')): ?>
    <?= $this->extend('layouts/admin_layout'); ?>
<?php else: ?>
    <?= $this->extend('layouts/public_layout'); ?>
<?php endif; ?>

<?= $this->section('content'); ?>
<div class="bg-white shadow-sm rounded-lg p-8">
    <?php if (session('error')) :  ?>
        <div class="bg-red-100 text-red-800 text-sm font-medium me-2 px-4 py-2 rounded-sm mb-2">
            <?= session('error') ?? ''; ?>
        </div>
    <?php elseif (session('message')): ?>
        <div class="bg-green-100 text-green-800 text-sm font-medium me-2 px-4 py-2 rounded-sm mb-2">
            <?= session('message') ?? ''; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty(user())): ?>
        <h1 class="text-xl font-bold">Hello, <?= user()->username; ?>!</h1>
        <?php foreach (user()->getRoles() as $role): ?>
            <p>Role: <?= $role; ?></p>
        <?php endforeach; ?>

        <div class="">
            <div class="">

                <!-- Pie Chart: Product Category Distribution -->
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="pieChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart: Top 5 Categories with Most Products -->
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="barChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Line Chart: GPA per Semester -->
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="lineChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    <?php else: ?>
        <h1 class="text-xl font-bold mb-6">
            Welcome to Student Management System
        </h1>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    // Data dari controller
    const productsByCategory = <?= $productsByCategory ?>;
    const top5CategoriesOfProducts = <?= $top5CategoriesOfProducts; ?>;
    const productGrowth = <?= $productGrowth; ?>;

    console.table(productGrowth);

    const pieChart = new Chart(
        document.getElementById('pieChart'), {
            type: 'pie',
            data: productsByCategory,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Product Category Distribution'
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        }
    );

    const barChart = new Chart(
        document.getElementById('barChart'), {
            type: 'bar',
            data: top5CategoriesOfProducts,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Products'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Category'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 Categories with Most Products'
                    }
                }
            }
        }
    );

    const lineChart = new Chart(
        document.getElementById('lineChart'), {
            type: 'line',
            data: productGrowth,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 0,
                        max: 4,
                        title: {
                            display: true,
                            text: 'Total Products'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                },

                plugins: {
                    title: {
                        display: true,
                        text: 'Product Growth'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Month: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        }
    );
</script>
<?= $this->endSection(); ?>
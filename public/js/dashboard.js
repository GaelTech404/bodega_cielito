document.addEventListener("DOMContentLoaded", () => {
    if (!window.dashboardData) return;
    const {
        productosMasVendidos,
        ventasPorMes,
        topVendedores,
        ventasPorCategoria,
        comprasPorMes,
        productosStockBajo,
        productosMasRentables // ← ESTE FALTABA

    } = window.dashboardData;


    crearGraficoBarHorizontal('chartProductosMasVendidos', productosMasVendidos.labels, productosMasVendidos.data);
    crearGraficoLineAvanzado('chartVentasMes', ventasPorMes.labels, ventasPorMes.data);
    crearGraficoBar('chartTopVendedores', topVendedores.labels, topVendedores.data);
    crearGraficoDoughnut('chartVentasCategoria', ventasPorCategoria.labels, ventasPorCategoria.data);
    crearGraficoLineAvanzado('chartComprasMes', comprasPorMes.labels, comprasPorMes.data);
    crearGraficoStockBajo('chartStockBajo', productosStockBajo);
    crearGraficoBar('chartProductosRentables', productosMasRentables.labels, productosMasRentables.data);
    crearGraficoBar(
        'chartValorInventario',
        ['Valor Compra', 'Valor Venta'],
        [window.dashboardData.valorInventarioCompra, window.dashboardData.valorInventarioVenta]
    );


});

function crearGraficoBar(id, labels, data) {
    const baseColors = [
        'rgba(0, 225, 255, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(17, 17, 17, 0.7)'
    ];

    const backgroundColors = data.map((_, i) => baseColors[i % baseColors.length]);
    const borderColors = backgroundColors.map(c => c.replace('0.7', '1')); // opacidad al 100%

    new Chart(document.getElementById(id), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad',
                data: data,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
}
function crearGraficoDoughnut(id, etiquetas, valores, titulo = 'Distribución') {
    const baseColors = [
        'rgba(255, 99, 132, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 159, 64, 0.7)'
    ];

    const backgroundColors = valores.map((_, i) => baseColors[i % baseColors.length]);
    const borderColors = backgroundColors.map(c => c.replace('0.7', '1'));

    const data = {
        labels: etiquetas,
        datasets: [{
            data: valores,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 1
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: titulo
                }
            }
        }
    };

    new Chart(document.getElementById(id), config);
}

function crearGraficoLineAvanzado(id, labels, data) {
    function skipped(ctx, value) {
        return ctx.p0.skip || ctx.p1.skip ? value : undefined;
    }

    function down(ctx, value) {
        return ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;
    }

    new Chart(document.getElementById(id), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ventas por mes',
                data: data,
                borderColor: 'rgb(75, 192, 192)',
                spanGaps: true,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgba(0,0,0,0.2)') || down(ctx, 'rgb(192,75,75)'),
                    borderDash: ctx => skipped(ctx, [6, 6])
                },
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Ventas mensuales con saltos y caídas destacadas'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
function crearGraficoBarHorizontal(idCanvas, labels, data) {
    const ctx = document.getElementById(idCanvas).getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Cantidad vendida',
                data,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // 🔁 esto invierte los ejes
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
}

function crearGraficoStockBajo(id, productos) {
    const labels = productos.map(p => p.nombre);
    const stocks = productos.map(p => parseInt(p.stock));
    const backgroundColors = stocks.map(stock => {
        if (stock <= 10) return 'rgba(255, 0, 0, 0.7)';
        if (stock <= 15) return 'rgba(255, 165, 0, 0.7)';
        return 'rgba(75, 192, 192, 0.7)';
    });

    new Chart(document.getElementById(id), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Stock actual',
                data: stocks,
                backgroundColor: backgroundColors,
                borderColor: backgroundColors.map(c => c.replace('0.7', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',

            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => `Stock: ${ctx.parsed.x}`
                    }
                }
            },
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
}


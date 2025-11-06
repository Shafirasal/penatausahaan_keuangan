
// "use strict";

// document.addEventListener("DOMContentLoaded", function () {

//   // ===== Chart 1: Line =====
//   const ctx1 = document.getElementById("myChart");
//   if (ctx1) {
//     const chart1 = new Chart(ctx1.getContext('2d'), {
//       type: 'line',
//       data: {
//         labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
//         datasets: [{
//           label: 'Statistics',
//           data: [460, 458, 330, 502, 430, 610, 488],
//           backgroundColor: '#6777ef',
//           borderColor: '#6777ef',
//           borderWidth: 2.5,
//           pointBackgroundColor: '#ffffff',
//           pointRadius: 4
//         }]
//       },
//       options: {
//         legend: { display: false },
//         scales: {
//           yAxes: [{
//             gridLines: { drawBorder: false, color: '#f2f2f2' },
//             ticks: { beginAtZero: true, stepSize: 150 }
//           }],
//           xAxes: [{
//             ticks: { display: false },
//             gridLines: { display: false }
//           }]
//         }
//       }
//     });
//   }

//   // ===== Chart 2: Bar =====
//   const ctx2 = document.getElementById("myChart2");

//   if (ctx2) {
//     fetch('/dashboard/perbandingan')
//       .then(res => res.json())
//       .then(data => {
//         const labels = data.map(item => item.tahun);
//         const totalAnggaran = data.map(item => item.total_anggaran);
//         const totalRealisasi = data.map(item => item.total_realisasi);
//         const totalSisa = data.map(item => item.total_sisa);

//         new Chart(ctx2.getContext('2d'), {
//           type: 'bar',
//           data: {
//             labels: labels,
//             datasets: [
//               {
//                 label: 'Total Anggaran',
//                 data: totalAnggaran,
//                 backgroundColor: '#FFA726'
//               },
//               {
//                 label: 'Total Realisasi',
//                 data: totalRealisasi,
//                 backgroundColor: '#42A5F5'
//               },
//               {
//                 label: 'Total Sisa',
//                 data: totalSisa,
//                 backgroundColor: '#66BB6A'
//               }
//             ]
//           },
//           options: {
//             responsive: true,
//             scales: {
//               yAxes: [{
//                 ticks: { beginAtZero: true }
//               }]
//             }
//           }
//         });
//       });
//   }

//   // ===== Chart 3: Doughnut =====
//   const ctx3 = document.getElementById("myChart3");
//   if (ctx3) {
//     const chart3 = new Chart(ctx3.getContext('2d'), {
//       type: 'doughnut',
//       data: {
//         datasets: [{
//           data: [80, 50, 40, 30, 20],
//           backgroundColor: ['#191d21', '#63ed7a', '#ffa426', '#fc544b', '#6777ef'],
//           label: 'Dataset 1'
//         }],
//         labels: ['Black', 'Green', 'Yellow', 'Red', 'Blue']
//       },
//       options: {
//         responsive: true,
//         legend: { position: 'bottom' }
//       }
//     });
//   }

// // ===== Chart 4: Pie - Realisasi Per Kegiatan Program 2 =====
// const ctx4 = document.getElementById("myChart4");
// if (ctx4) {
//   const chartData = @json($realisasiPerKegiatanProgram2);
  
//   const labels = chartData.map(item => item.nama_kegiatan);
//   const values = chartData.map(item => item.total_realisasi);
//   const percentages = chartData.map(item => item.persentase);
  
//   const colors = ['#6777ef', '#fc544b', '#ffa426', '#63ed7a', '#191d21', '#3abaf4', '#feb019', '#ff6178', '#5a8dee', '#39da8a'];
//   const backgroundColor = labels.map((_, index) => colors[index % colors.length]);
  
//   const chart4 = new Chart(ctx4.getContext('2d'), {
//     type: 'pie',
//     data: {
//       datasets: [{
//         data: values,
//         backgroundColor: backgroundColor,
//         borderWidth: 2,
//         borderColor: '#fff'
//       }],
//       labels: labels
//     },
//     options: {
//       responsive: true,
//       maintainAspectRatio: false,
//       title: {
//         display: true,
//         text: 'Realisasi Anggaran Per Kegiatan - Program 2',
//         fontSize: 16
//       },
//       legend: { 
//         position: 'right',
//         labels: {
//           boxWidth: 15,
//           padding: 15,
//           fontSize: 12
//         }
//       },
//       tooltips: {
//         callbacks: {
//           label: function(tooltipItem, data) {
//             const currentValue = data.datasets[0].data[tooltipItem.index];
//             const percentage = percentages[tooltipItem.index];
//             const label = data.labels[tooltipItem.index];
//             const formattedValue = new Intl.NumberFormat('id-ID', {
//               style: 'currency',
//               currency: 'IDR',
//               minimumFractionDigits: 0
//             }).format(currentValue);
            
//             return label + ': ' + formattedValue + ' (' + percentage + '%)';
//           }
//         }
//       }
//     }
//   });
// }
// });
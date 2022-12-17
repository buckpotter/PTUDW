<x-layout>
  <h1 class="header">Nhà xe {{ $Ten_NX }}</h1>
  <div class="bg-white mt-4">
    <canvas id="admin-bus-companies-income"></canvas>
    <canvas id="admin-potential-users"></canvas>
  </div>

  <script>
    Chart.register(ChartDataLabels);

    const adminBusCompIncomeEl = document.getElementById('admin-bus-companies-income');
    const adminPotentialUsersEl = document.getElementById('admin-potential-users');

    // plugins object dùng cho định dạng tiền tệ và hiển thị giá trị tiền tệ trên chart
    const pluginsTop = {
      datalabels: {
        anchor: 'end',
        align: 'top',

        formatter: (value, context) => {
          return value.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
          });
        },

        font: {
          size: 12,
          weight: 'bold'
        }
      }
    };

    const pluginsCenter = {
      datalabels: {
        align: 'center',

        formatter: (value, context) => {
          return value.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
          });
        },

        font: {
          size: 12,
          weight: 'bold'
        }
      }
    };

    // ticks object cho định dạng tiền tệ cho trục y của chart
    ticks = {
      callback: function(value, index, values) {
        return new Intl.NumberFormat('vi-VN', {
          style: 'currency',
          currency: 'VND'
        }).format(value);
      }
    };

    let gradient = adminBusCompIncomeEl.getContext('2d').createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(173, 231, 146, 1)');
    gradient.addColorStop(1, 'rgba(173, 231, 146, 0.3)');


    // Thống kê doanh thu theo tháng trong năm 2022 của nhà xe admin đang đăng nhập
    let data = [];
    let labels = [];
    const Ten_NX = "{{ $Ten_NX }}";
    <?php
    foreach ($adminBCIncome as $abci) {
      echo "data.push({$abci->income});";
      echo "labels.push('Tháng {$abci->month}');";
    }
    ?>

    new Chart(adminBusCompIncomeEl, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          label: `Doanh thu trong năm 2022 theo tháng của nhà xe ${Ten_NX}`,
          borderWidth: 3,
          fill: true,
          backgroundColor: gradient,
          borderColor: 'lightgreen',
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: ticks
          }
        },

        plugins: pluginsTop
      }
    });

    // Top 10 người dùng tiềm năng của nhà xe admin quản lý
    data = [];
    labels = [];
    <?php
    foreach ($adminPotentialUsers as $apu) {
      echo "data.push({$apu->sum});";
      echo "labels.push('{$apu->IdUser} {$apu->HoTen}');";
    }
    ?>
    new Chart('admin-potential-users', {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          label: 'Top 10 người dùng tiềm năng',
          borderWidth: 3,
          fill: true,
        }]
      },
      options: {
        indexAxis: 'y',
        scales: {
          x: {
            beginAtZero: true,
            ticks: ticks
          }
        },

        plugins: pluginsCenter
      }
    })
  </script>
</x-layout>
<x-layout>
  <div class="grid grid-rows-1 md:grid-cols-2 xl:grid-cols-4 justify-between gap-4">
    @foreach ($data as $key=>$value)
    <div class="inline-flex items-center bg-white border rounded-lg shadow-md hover:bg-gray-200 p-2">
      <img class="w-[100px]" src="{{ asset($value[1]) }}">

      <div class="flex flex-col justify-between p-4 leading-normal">
        <h2 class="mb-2 font-bold tracking-tight text-gray-900">{{ $key }}</h2>
        <p class="mb-3 text-gray-500">{{ $value[0] }}</p>
      </div>
    </div>
    @endforeach
  </div>

  <div class="bg-white mt-4">
    <canvas id="income"></canvas>
    <canvas id="bus-companies-income"></canvas>
    <canvas id="potentialUsers"></canvas>
    <div class="flex justify-around flex-col md:flex-row">
      <canvas id="bus-type"></canvas>
      <canvas id="ticket-status"></canvas>
    </div>

    <div class="mt-10 flex flex-col text-center">
      <h1 class="sub-header">Xem thống kê của nhà xe cụ thể</h1>
      <form action="{{ route('admin.show') }}" class="flex flex-col p-4 gap-4">
        <select name="IdNX" id="IdNX" class="w-fit mx-auto">
          <option value="none">Chọn nhà xe</option>
          @foreach ($busComps as $busComp)
          <option value="{{ $busComp->IdNX }}">{{ $busComp->Ten_NX }}</option>
          @endforeach
        </select>
        <button type="submit" class="primary-btn w-fit mx-auto">Xem thống kê</button>
      </form>
    </div>
  </div>

  <script>
    Chart.register(ChartDataLabels);

      const incomeEl = document.getElementById('income');
      const busCompIncomeEl = document.getElementById('bus-companies-income');
      const busTypeEl = document.getElementById('bus-type');
      const ticketStatusEl = document.getElementById('ticket-status');
      const potentialUsersEl = document.getElementById('potentialUsers');

      // plugins object dùng cho định dạng tiền tệ và hiển thị giá trị tiền tệ trên chart
      plugins = {
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

      // ticks object cho định dạng tiền tệ cho trục y của chart
      ticks = {
        callback: function(value, index, values) {
          return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
          }).format(value);
        }
      }

      // Thống kê doanh thu theo tháng trong năm 2022 trên toàn hệ thống
      let data = [];
      let labels = [];
      <?php
      foreach ($income as $i) {
        echo "data.push({$i->income});";
        echo "labels.push('Tháng {$i->month}');";
      }
      ?>


      let gradient = incomeEl.getContext('2d').createLinearGradient(0, 0, 0, 400);
      gradient.addColorStop(0, 'rgba(173, 231, 146, 1)');
      gradient.addColorStop(1, 'rgba(173, 231, 146, 0.3)');
      new Chart(incomeEl, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            data: data,
            label: "Doanh thu trong năm 2022 theo tháng trên toàn hệ thống",
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

          plugins: plugins
        }
      });

      // Top 10 nhà xe có doanh thu cao nhất trong năm 2022
      data = [];
      labels = [];
      <?php
      foreach ($busCompIncome as $bci) {
        echo "data.push({$bci->income});";
        echo "labels.push('{$bci->Ten_NX}');";
      }
      ?>

      new Chart(busCompIncomeEl, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            data: data,
            label: "Top 10 nhà xe có doanh thu cao nhất trong năm 2022",
            borderWidth: 3,
            fill: true,
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: ticks
            }
          },

          plugins: plugins
        }
      });

      // Top 10 người dùng tiềm năng
      data = [];
      labels = [];
      <?php
      foreach ($potentialUsers as $pu) {
        echo "data.push({$pu->sum});";
        echo "labels.push('{$pu->IdUser} {$pu->HoTen}');";
      }
      ?>
      new Chart(potentialUsersEl, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            data: data,
            label: "Top 10 người dùng tiềm năng",
            borderWidth: 3,
            fill: true,
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: ticks
            }
          },

          plugins: plugins
        }
      });


      // Thống kê loại xe
      data = [];
      labels = [];
      <?php
      foreach ($busTypes as $b) {
        echo "labels.push('{$b->Loai_Xe}');";
        echo "data.push({$b->count});";
      }
      ?>

      new Chart(busTypeEl, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            data: data,
          }]
        },
        options: {
          plugins: {
            legend: {
              position: 'bottom'
            },
            title: {
              display: true,
              text: 'Thống kê loại xe trên toàn hệ thống',
              font: {
                size: 20
              }
            },
            datalabels: {
              font: {
                size: 20,
                weight: 'bold',
              }
            },
          }
        }
      });

      data = [];
      labels = [];
      <?php
      foreach ($ticketStatus as $t) {
        echo "labels.push('{$t->TinhTrangVe}');";
        echo "data.push({$t->count});";
      }
      ?>

      // Thống kê tình trạng vé
      new Chart(ticketStatusEl, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            data: data,
          }]
        },
        options: {
          plugins: {
            legend: {
              position: 'bottom'
            },
            title: {
              display: true,
              text: 'Thống kê tình trạng vé trên toàn hệ thống',
              font: {
                size: 20
              }
            },
            datalabels: {
              font: {
                size: 20,
                weight: 'bold',
              },
              formatter: (value, context) => {
                // Định dạng kiểu tiền tệ
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
              },
            },
          }
        }
      });
  </script>
</x-layout>
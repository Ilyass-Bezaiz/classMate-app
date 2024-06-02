<div>
  <canvas id="absencesChart" height="50"></canvas>
</div>
@script
  <script>
    const ctx = document.getElementById('absencesChart').getContext('2d');
    let chartData = @json($absencesPerDepartment);

    const labels = chartData.map(item => item.department);
    const data = chartData.map(item => item.absence_count);

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Student Absences per Department',
          data: data,
          backgroundColor: 'rgba(63, 81, 181, .2)',
          borderColor: 'rgba(63, 81, 181, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        // scales: {
        //   x: {
        //     display: true,
        //     title: {
        //       display: true,
        //       text: 'Department'
        //     }
        //   },
        //   y: {
        //     display: true,
        //     title: {
        //       display: true,
        //       text: 'Number of Absences'
        //     }
        //   }
        // }
      }
    });
    console.log(data);
  </script>
@endscript

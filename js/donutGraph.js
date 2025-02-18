const donutData = [
    { age: '16', count: 5 },
    { age: '17', count: 8 },
    { age: '18', count: 12 },
    { age: '19', count: 6 },
    { age: '20', count: 9 },
  ];
  
  const donutWidth = 650;
  const donutHeight = 450;
  const radius = Math.min(donutWidth, donutHeight) / 4;
  
  const donutSvg = d3.select('#donut-graph')
    .append('svg')
    .attr('width', donutWidth)
    .attr('height', donutHeight)
    .append('g')
    .attr('transform', `translate(${donutWidth / 2}, ${donutHeight / 2})`);
  
  const color = d3.scaleOrdinal()
    .domain(donutData.map(d => d.age))
    .range(d3.schemeCategory10);
  
  // Create a pie generator
  const pie = d3.pie()
    .value(d => d.count);
  
  // Create an arc generator
  const arc = d3.arc()
    .innerRadius(radius * 0.5) // Inner radius for the donut hole
    .outerRadius(radius);
  
  // Add slices
  donutSvg.selectAll('path')
    .data(pie(donutData))
    .join('path')
    .attr('d', arc)
    .attr('fill', d => color(d.data.age))
    .attr('stroke', 'white')
    .attr('stroke-width', 2)
    .on('mouseover', (event, d) => {
      d3.select(event.target).attr('opacity', 0.7);
    })
    .on('mouseout', (event, d) => {
      d3.select(event.target).attr('opacity', 1);
    });
  
  // Add labels
  donutSvg.selectAll('text')
    .data(pie(donutData))
    .join('text')
    .attr('transform', d => `translate(${arc.centroid(d)})`)
    .attr('text-anchor', 'middle')
    .style('font-size', '12px')
    .style('fill', 'black')
    .text(d => `${d.data.age}: ${d.data.count}`);
  
  // Add title
  donutSvg.append('text')
    .attr('x', 0)
    .attr('y', -donutHeight / 3)
    .attr('text-anchor', 'middle')
    .style('font-size', '24px')
 
    .text('Number of Students by Age');

//     const legendWidth = 100;
// const legendHeight = 200;
// const legend = d3.select('#donut-graph').append('svg')
//   .attr('width', legendWidth)
//   .attr('height', legendHeight)
//   .style('position', 'absolute')
//   .style('top', '0')
//   .style('left', `${donutWidth + 20}px`);

// legend.selectAll('rect')
//   .data(donutData)
//   .join('rect')
//   .attr('x', 10)
//   .attr('y', (d, i) => i * 30 + 20)
//   .attr('width', 20)
//   .attr('height', 20)
//   .attr('fill', d => color(d.age));

// legend.selectAll('text')
//   .data(donutData)
//   .join('text')
//   .attr('x', 40)
//   .attr('y', (d, i) => i * 30 + 35)
//   .style('font-size', '14px')
//   .style('fill', 'black')
//   .text(d => `Age ${d.age}: ${d.count} students`);
  
    
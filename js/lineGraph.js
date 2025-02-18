const lineWidth = 1100;
const lineHeight = 300;


// Fetch data from the PHP file
fetch('data/lineGraph.php')
  .then(response => response.json())
  .then(courseData => {
    console.log('Course Data:', courseData); 

    // Create the SVG container for the graph
    const lineSvg = d3.select('#line-graph')
      .append('svg')
      .attr('width', lineWidth)
      .attr('height', lineHeight)
      .append('g')
      .attr('transform', `translate(${margin.left}, ${margin.top})`);

    // Set up scales for the axes
    const x = d3.scaleBand()
      .domain(courseData.map(d => d.course))
      .range([0, lineWidth - margin.left - margin.right])
      .padding(0.1);

    const y = d3.scaleLinear()
      .domain([0, d3.max(courseData, d => d.students)])
      .nice()
      .range([lineHeight - margin.top - margin.bottom, 0]);

    // Create line generator
    const line = d3.line()
      .x(d => x(d.course) + x.bandwidth() / 2)
      .y(d => y(d.students));

    // Add line path
    lineSvg.append('path')
      .datum(courseData)
      .attr('fill', 'none')
      .attr('stroke', 'steelblue')
      .attr('stroke-width', 2)
      .attr('d', line);

    // Add points for each data point on the line
    lineSvg.selectAll('circle')
      .data(courseData)
      .join('circle')
      .attr('cx', d => x(d.course) + x.bandwidth() / 2)
      .attr('cy', d => y(d.students))
      .attr('r', 5)
      .attr('fill', 'steelblue');

    // Add labels for each data point
    lineSvg.selectAll('text.point-label')
      .data(courseData)
      .join('text')
      .attr('class', 'point-label')
      .attr('x', d => x(d.course) + x.bandwidth() / 2)
      .attr('y', d => y(d.students) - 10) // Position slightly above the point
      .attr('text-anchor', 'middle')
      .style('font-size', '10px')
      .style('fill', 'black')
      .text(d => d.students);

    // Add X Axis
    lineSvg.append('g')
      .attr('transform', `translate(0,${lineHeight - margin.top - margin.bottom})`)
      .call(d3.axisBottom(x))
      .selectAll('text')
      .attr('font-size', '12px')
      .attr('fill', 'black');

    // Add Y Axis
    lineSvg.append('g')
      .call(d3.axisLeft(y).ticks(5))
      .selectAll('text')
      .attr('font-size', '12px')
      .attr('fill', 'black');

    // Add Title
    lineSvg.append('text')
      .attr('x', (lineWidth - margin.left - margin.right) / 2)
      .attr('y', -20)
      .attr('text-anchor', 'middle')
      .style('font-size', '24px')
      .text('Total Students by Course');
  })
  .catch(error => console.error('Error loading data:', error));

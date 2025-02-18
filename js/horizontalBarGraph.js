fetch('data/horiBarGraph.php') // Adjust this endpoint to your server-side PHP script
  .then(response => response.json())
  .then(data => {
    console.log(data); // Ensure the data format is correct

    // Create the SVG container
    const svgHorizontal = d3.select('#horizontal-bar-graph')
      .append('svg')
      .attr('width', width)
      .attr('height', height);

    // Define the scales
    const yHorizontal = d3.scaleBand()
      .domain(data.map(d => d.department_code)) // Map department codes for Y-axis
      .range([margin.top, height - margin.bottom])
      .padding(0.1);

    const xHorizontal = d3.scaleLinear()
      .domain([0, d3.max(data, d => d.teachers || 0)]) // Use max total_teachers for X-axis
      .range([margin.left, width - margin.right]);

    
    const colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b'];

    // Create the bars
    svgHorizontal.append("g")
    .selectAll("rect")
    .data(data)
    .join("rect")
    .attr("x", xHorizontal(0))
    .attr("y", d => yHorizontal(d.department_code))
    .attr("width", d => xHorizontal(d.teachers) - xHorizontal(0))
    .attr("height", yHorizontal.bandwidth())
    .attr("fill", (d, i) => colors[i % colors.length]);

    // Add the X-axis
    svgHorizontal.append("g")
      .attr("transform", `translate(0,${height - margin.bottom})`)
      .call(d3.axisBottom(xHorizontal))
      .selectAll("text")
      .attr("fill", "black");

    // Add the Y-axis
    svgHorizontal.append("g")
      .attr("transform", `translate(${margin.left}, 0)`)
      .call(d3.axisLeft(yHorizontal))
      .selectAll("text")
      .attr("fill", "black");

    // Add the title
    svgHorizontal.append("text")
      .attr("x", width / 2)
      .attr("y", margin.top / 2)
      .attr("text-anchor", "middle")
      .style("font-size", "24px")
      .text("Total Teachers by Department");

    svgHorizontal.append("g")
    .selectAll("text")
    .data(data)
    .join("text")
    .attr("x", d => xHorizontal(d.teachers) + 5) 
    .attr("y", d => yHorizontal(d.department_code) + yHorizontal.bandwidth() / 2) 
    .attr("dy", "0.35em") 
    .text(d => d.teachers) 
    .style("font-size", "12px")
    .attr("fill", "black"); 
  })

  
  .catch(error => console.error('Error fetching data:', error));
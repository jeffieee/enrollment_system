
  
  const width = 530;
  const height = 330;
  const margin = { top: 50, bottom: 50, left: 50, right: 50 };
  
  fetch('data/verticalBarGraph.php')
  .then(response => response.json())
  .then(data => {
    console.log(data);

    // Set up the SVG container
    const svgVertical = d3.select('#bar-graph')
      .append('svg')
      .attr('width', width)
      .attr('height', height);

    // Set up scales
    const xVertical = d3.scaleBand()
      .domain(data.map(d => d.age))
      .range([margin.left, width - margin.right])
      .padding(0.1);

    const yVertical = d3.scaleLinear()
      .domain([0, d3.max(data, d => d.students)])
      .range([height - margin.bottom, margin.top]);

    const colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728'];

    // Add bars
    svgVertical.append("g")
      .selectAll("rect")
      .data(data)
      .join("rect")
      .attr("x", d => xVertical(d.age))
      .attr("y", d => yVertical(d.students))
      .attr("height", d => yVertical(0) - yVertical(d.students))
      .attr("width", xVertical.bandwidth())
      .attr("fill", (d, i) => colors[i % colors.length]);

    // Add bar labels
    svgVertical.append("g")
      .selectAll("text.bar-label")
      .data(data)
      .join("text")
      .attr("class", "bar-label")
      .attr("x", d => xVertical(d.age) + xVertical.bandwidth() / 2)
      .attr("y", d => yVertical(d.students) - 5)
      .attr("text-anchor", "middle")
      .text(d => d.students)
      .style("font-size", "10px")
      .attr("fill", "black");

    // Add X Axis
    svgVertical.append("g")
      .attr("transform", `translate(0,${height - margin.bottom})`)
      .call(d3.axisBottom(xVertical).tickFormat(d => `Age ${d}`))
      .selectAll("text")
      .attr("font-size", '10px')
      .attr("fill", "black");

    // Add Y Axis
    svgVertical.append("g")
      .attr("transform", `translate(${margin.left}, 0)`)
      .call(d3.axisLeft(yVertical))
      .selectAll("text")
      .attr("fill", "black");

    // Add Title
    svgVertical.append("text")
      .attr("x", width / 2)
      .attr("y", margin.top / 2)
      .attr("text-anchor", "middle")
      .style("font-size", "24px")
      .text("Total Students by Age");
  });


  
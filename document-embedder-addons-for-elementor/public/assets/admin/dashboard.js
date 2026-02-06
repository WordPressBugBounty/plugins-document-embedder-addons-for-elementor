const { render } = wp.element;

// import './dashboard.scss';
import App from './Components/App';
import { dashboardInfo } from './utils/data';

document.addEventListener('DOMContentLoaded', () => {
	const dashboardElbptb = document.getElementById('bptbDashboard');
	const info = JSON.parse(dashboardElbptb.dataset.info);

	render(<App {...dashboardInfo(info)} />, dashboardElbptb);
});




// function Dashboard() {
//   return (
//     <div style={{ padding: '20px' }}>
//       <h1>🚀 My React Plugin Dashboard</h1>
//       <p>This is powered by React inside WordPress Admin!</p>
//     </div>
//   );
// }

// document.addEventListener("DOMContentLoaded", () => {
//   render(<Dashboard />, document.getElementById("my-react-dashboard"));
// });
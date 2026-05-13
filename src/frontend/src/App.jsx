import { useState, useEffect } from 'react'
import api from './lib/axios'
import RevenueChart from './components/ui/revenueChart';

function App() {
  const [tenants, setTenants] = useState([]);
  const [activeTenant, setActiveTenant] = useState('');
  const [metrics, setMetrics] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    api.get('/tenants').then(res => {
      setTenants(res.data);
      if (res.data.length > 0) setActiveTenant(res.data[0].id);
    });
  }, []);

  // 2. This effect runs every time activeTenant changes
  useEffect(() => {
    if (!activeTenant) return;
    
    api.get(`/metrics?tenant_id=${activeTenant}`).then(res => setMetrics(res.data));
    api.get(`/metrics/trend?tenant_id=${activeTenant}`).then(res => setChartData(res.data.data));
  }, [activeTenant]);

  useEffect(() => {
    // PASTE YOUR COPIED UUID HERE
    const tenantId = 'f62fa46d-0a04-4ebd-a485-0fba92b83c25'; 

    api.get(`/metrics?tenant_id=${tenantId}`)
      .then(response => {
        console.log("Real Data Received:", response.data);
        setMetrics(response.data);
        setLoading(false);
      })
      .catch(error => {
        console.error("API Error:", error);
        setLoading(false);
      });
  }, []);

  const [chartData, setChartData] = useState([]);

  useEffect(() => {
      const tenantId = 'f62fa46d-0a04-4ebd-a485-0fba92b83c25';

      // Fetch Trend Data
      api.get(`/metrics/trend?tenant_id=${tenantId}`)
        .then(response => {
          setChartData(response.data.data);
        })
        .catch(err => console.error("Trend Error:", err));
  }, []);

  if (loading) return <div className="p-8">Calculating your revenue...</div>

  return (

    <div className="p-8 bg-gray-50 min-h-screen">
      {/* THE TENANT SWITCHER (Your Admin Tool) */}
      <div className="mb-6 flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm">
        <label className="font-bold text-gray-700">Testing as Tenant:</label>
        <select 
          className="border p-2 rounded bg-gray-50"
          value={activeTenant}
          onChange={(e) => setActiveTenant(e.target.value)}
        >
          {tenants.map(t => (
            <option key={t.id} value={t.id}>{t.name}</option>
          ))}
        </select>
      </div>

      <div className="min-h-screen bg-gray-50 p-8">
      <h1 className="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>
      
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
          <p className="text-sm font-medium text-gray-500">Monthly Recurring Revenue</p>
          <p className="text-2xl font-bold text-blue-600">
            ${metrics?.mrr?.toFixed(2) || '0.00'}
          </p>
        </div>
      </div>
      <div className="mt-8">
        <RevenueChart data={chartData} />
      </div>
    </div>
    </div>

    
  )
}

export default App
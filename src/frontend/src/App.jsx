import { useState, useEffect } from 'react'
import api from './lib/axios'

function App() {
  const [metrics, setMetrics] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
  // PASTE YOUR COPIED UUID HERE
  const tenantId = 'bb02735c-455d-4af1-93e7-bade8dde50e8'; 

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

  if (loading) return <div className="p-8">Calculating your revenue...</div>

  return (
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
    </div>
  )
}

export default App
import React, { useState, useEffect } from 'react';
import Login from './components/Login';
import api from './lib/axios';
import RevenueChart from './components/ui/revenueChart';

function App() {
  // Initialize user from localStorage to persist session on refresh
  const [user, setUser] = useState(JSON.parse(localStorage.getItem('user')));
  const [metrics, setMetrics] = useState(null);
  const [chartData, setChartData] = useState([]);
  const [loading, setLoading] = useState(false);

  // Function passed to Login component
  const handleLoginSuccess = (userData) => {
    setUser(userData);
  };

  const handleLogout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    setUser(null);
    setMetrics(null);
    setChartData([]);
  };

  // Main Data Fetcher - runs only when user changes (login/logout)
  useEffect(() => {
    if (user) {
      setLoading(true);
      
      // We use Promise.all to fetch both metrics and trend data simultaneously
      Promise.all([
        api.get('/metrics'),
        api.get('/metrics/trend')
      ])
        .then(([metricsRes, trendRes]) => {
          // Adjusting based on your Laravel 'status' => 'success', 'data' => $metrics wrapper
          setMetrics(metricsRes.data.data);
          setChartData(trendRes.data.data);
          setLoading(false);
        })
        .catch(error => {
          console.error("Dashboard Loading Error:", error);
          setLoading(false);
          // If token is expired, force logout
          if (error.response?.status === 401) handleLogout();
        });
    }
  }, [user]);

  // If not logged in, show the Login Page
  if (!user) {
    return <Login onLoginSuccess={handleLoginSuccess} />;
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Professional Navbar */}
      <nav className="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
        <div>
          <h1 className="text-xl font-bold text-blue-600">Subtrack Analytics</h1>
          <p className="text-xs text-gray-400 font-medium uppercase tracking-wider">
            SaaS Insights Engine
          </p>
        </div>
        
        <div className="flex items-center gap-6">
          <div className="text-right">
            <p className="text-sm font-bold text-gray-900">{user.name}</p>
            <p className="text-xs text-gray-500">Tenant ID: {user.tenant_id.substring(0, 8)}...</p>
          </div>
          <button 
            onClick={handleLogout}
            className="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors"
          >
            Logout
          </button>
        </div>
      </nav>

      <main className="p-8 max-w-7xl mx-auto">
        <header className="mb-8">
          <h2 className="text-2xl font-bold text-gray-900">Enterprise Overview</h2>
          <p className="text-gray-500">Performance data for your specific organization.</p>
        </header>

        {loading ? (
          <div className="flex items-center justify-center h-64">
            <div className="animate-pulse text-gray-400 font-medium">Synchronizing with PostgreSQL...</div>
          </div>
        ) : (
          <>
            {/* Stat Cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
              <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p className="text-sm font-medium text-gray-500 uppercase">Monthly Recurring Revenue</p>
                <p className="text-3xl font-bold text-gray-900 mt-2">
                  ${metrics?.mrr?.toFixed(2) || '0.00'}
                </p>
              </div>

              <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p className="text-sm font-medium text-gray-500 uppercase">Active Subscriptions</p>
                <p className="text-3xl font-bold text-gray-900 mt-2">
                  {metrics?.active_subscriptions || '0'}
                </p>
              </div>

              <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p className="text-sm font-medium text-gray-500 uppercase">Churn Rate</p>
                <p className="text-3xl font-bold text-red-600 mt-2">
                  {metrics?.churn_rate || '0'}%
                </p>
              </div>
            </div>

            <section className="mt-8">
              <h3 className="text-lg font-bold text-gray-900 mb-4">Resource Usage</h3>
              <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                {metrics?.usage_stats?.map((stat, index) => (
                  <div key={index} className="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                    <p className="text-xs font-semibold text-gray-400 uppercase">{stat.type.replace('_', ' ')}</p>
                    <p className="text-xl font-bold text-gray-800 mt-1">{stat.total.toLocaleString()}</p>
                  </div>
                ))}
                {(!metrics?.usage_stats || metrics.usage_stats.length === 0) && (
                  <p className="text-sm text-gray-400 italic">No usage data recorded for this period.</p>
                )}
              </div>
            </section>

            {/* Growth Chart */}
            <RevenueChart data={chartData} />
          </>
        )}
      </main>
    </div>
  );
}

export default App;
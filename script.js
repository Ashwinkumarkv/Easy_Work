document.addEventListener('DOMContentLoaded', function() {
    // Fetch service providers based on selected service type
    function fetchServiceProviders(serviceType) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `fetch_service_providers.php?serviceType=${serviceType}`);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const serviceProviders = JSON.parse(xhr.responseText);
          renderServiceProviders(serviceProviders);
        } else {
          console.error('Error fetching service providers');
        }
      };
      xhr.send();
    }
  
    // Render service provider cards
    function renderServiceProviders(serviceProviders) {
      const container = document.getElementById('serviceProvidersContainer');
      container.innerHTML = ''; // Clear previous cards
  
      serviceProviders.forEach(function(serviceProvider) {
        const card = createCard(serviceProvider);
        container.appendChild(card);
      });
    }
  
    // Create a service provider card
    function createCard(serviceProvider) {
      const card = document.createElement('div');
      card.classList.add('service-provider-card');
  
      // Customize the card layout and content based on your design
  
      return card;
    }
  
    // Event listener for selecting a service type
    const serviceTypeSelect = document.getElementById('serviceType');
    serviceTypeSelect.addEventListener('change', function() {
      const selectedServiceType = serviceTypeSelect.value;
      fetchServiceProviders(selectedServiceType);
    });
  });
  
 
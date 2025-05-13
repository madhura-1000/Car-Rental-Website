function openLogin() {
  document.getElementById('loginModal').style.display = 'flex';
  document.querySelector(".navbar").style.display = "none";
}


function closeLogin() {
  document.getElementById('loginModal').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    centeredSlides: false,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    breakpoints: {
      576: { slidesPerView: 2, spaceBetween: 20 },
      992: { slidesPerView: 3, spaceBetween: 30 },
    },
  });

});



document.addEventListener("DOMContentLoaded", function () {
  const faqItems = document.querySelectorAll(".faq_item");

  faqItems.forEach((item) => {
    item.addEventListener("click", function () {
      this.classList.toggle("active");
    });
  });
});








document.addEventListener("DOMContentLoaded", () => {
  const chatbotWrapper = document.querySelector(".showchatbot");
  const toggleButton = document.querySelector(".chatbot-hide");

  toggleButton.addEventListener("click", () => {
    chatbotWrapper.classList.toggle("showchatbot");
  });
});


const ChatInput = document.querySelector(".chat-input textarea");
const sendChatbtn = document.querySelector(".chat-input span");
const chatbot = document.querySelector(".chatbox"); 

let userMessage;

const botReplies = [
  {
    question: /what.*cars.*available|car options|types of cars/i,
    answer: "We offer a variety of cars including sedans, SUVs, and luxury vehicles. What type are you interested in?"
  },
  {
    question: /how.*much.*cost|price.*rent/i,
    answer: "Our rental rates start at $29/day depending on the vehicle and rental duration. Would you like a quote?"
  },
  {
    question: /insurance/i,
    answer: "Yes, we offer full coverage insurance options for your peace of mind."
  },
  {
    question: /pick.*up|where.*pickup/i,
    answer: "You can pick up the car from any of our city branches or choose home delivery for convenience."
  },
  {
    question: /return.*different.*location|one-way/i,
    answer: "Absolutely! We support one-way rentals for most locations. Just let us know your return point."
  },
  {
    question: /what.*need.*rent/i,
    answer: "You'll need a valid driver's license, a credit card, and be at least 21 years old."
  },
  {
    question: /mileage/i,
    answer: "Most rentals come with unlimited mileage. Some exceptions may apply. Ask for details."
  },
  {
    question: /cancel.*reservation/i,
    answer: "Yes, you can cancel or modify your reservation up to 24 hours before the pickup time."
  },
  {
    question: /discount/i,
    answer: "Yes, we offer discounts for early bookings, long-term rentals, and corporate clients."
  }
];

function getBotReply(userMsg) {
  for (let pair of botReplies) {
    if (pair.question.test(userMsg)) {
      return pair.answer;
    }
  }
  return "I'm not sure about that, but I can connect you with a human agent!";
}



const createChat = (message, className) => {
  const Chatli = document.createElement("li");
  Chatli.classList.add("chat", className);

  let chatContent = className === "outgoing"
    ? `<p>${message}</p>`
    : `<span><i class='bx bx-bot'></i></span><p>${message}</p>`;

  Chatli.innerHTML = chatContent;
  return Chatli;
};

const handleChat = () => {
  userMessage = ChatInput.value.trim();
  if (!userMessage) return;


  chatbot.appendChild(createChat(userMessage, "outgoing"));

  
  ChatInput.value = "";


  setTimeout(() => {
    const botResponse = getBotReply(userMessage);
    chatbot.appendChild(createChat(botResponse, "incoming"));
    chatbot.scrollTop = chatbot.scrollHeight;
  }, 600);
};

sendChatbtn.addEventListener("click", handleChat);

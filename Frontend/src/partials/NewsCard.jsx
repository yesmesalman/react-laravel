import React, { useState, useRef, useEffect } from "react";

function NewsCard({ item }) {
  const { title, description, url } = item;

  return (
    <div
      className="relative flex flex-col items-center"
      data-aos="fade-up"
      data-aos-anchor="[data-aos-id-blocks]"
    >
      <svg
        className="w-16 h-16 mb-4"
        viewBox="0 0 64 64"
        xmlns="http://www.w3.org/2000/svg"
      >
        <rect
          className="fill-current text-purple-600"
          width="64"
          height="64"
          rx="32"
        />
        <path
          className="stroke-current text-purple-100"
          d="M30 39.313l-4.18 2.197L27 34.628l-5-4.874 6.91-1.004L32 22.49l3.09 6.26L42 29.754l-3 2.924"
          strokeLinecap="square"
          strokeWidth="2"
          fill="none"
          fillRule="evenodd"
        />
        <path
          className="stroke-current text-purple-300"
          d="M43 42h-9M43 37h-9"
          strokeLinecap="square"
          strokeWidth="2"
        />
      </svg>
      <h4 className="h4 mb-2 text-center">{title}</h4>
      <p className="text-lg text-gray-400 text-center">{description}</p>
      <a
        className="text-purple-600 hover:text-gray-200 transition duration-150 ease-in-out"
        href={url}
        target="_blank"
      >
        View Article
      </a>
    </div>
  );
}

export default NewsCard;

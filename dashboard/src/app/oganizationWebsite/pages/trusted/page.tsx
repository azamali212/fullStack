import Image from "next/image";

export default function Trusted() {
  return (
    <div className="bg-[var(--website-primary-color)] py-24 sm:py-32">
      <div className="mx-auto max-w-7xl px-6 lg:px-8">
        <h2 className="text-center text-lg/8 font-semibold text-gray-900">
          Trusted by the world’s most innovative teams
        </h2>
        <div className="mx-auto mt-10 overflow-hidden">
          <div className="flex animate-marquee gap-x-8 items-center">
            <Image
              alt="Transistor"
              src="https://tailwindui.com/plus/img/logos/158x48/transistor-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="Reform"
              src="https://tailwindui.com/plus/img/logos/158x48/reform-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="Tuple"
              src="https://tailwindui.com/plus/img/logos/158x48/tuple-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="SavvyCal"
              src="https://tailwindui.com/plus/img/logos/158x48/savvycal-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="Statamic"
              src="https://tailwindui.com/plus/img/logos/158x48/statamic-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            {/* Duplicating the images for continuous scrolling effect */}
            <Image
              alt="Transistor"
              src="https://tailwindui.com/plus/img/logos/158x48/transistor-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="Reform"
              src="https://tailwindui.com/plus/img/logos/158x48/reform-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="Tuple"
              src="https://tailwindui.com/plus/img/logos/158x48/tuple-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="SavvyCal"
              src="https://tailwindui.com/plus/img/logos/158x48/savvycal-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
            <Image
              alt="Statamic"
              src="https://tailwindui.com/plus/img/logos/158x48/statamic-logo-gray-900.svg"
              width={158}
              height={48}
              className="max-h-12 w-full object-contain"
            />
          </div>
        </div>
      </div>
    </div>
  );
}
  
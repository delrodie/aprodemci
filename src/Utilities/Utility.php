<?php
	
	namespace App\Utilities;
	
	use App\Repository\ProducteurRepository;
	use Symfony\Component\HttpFoundation\File\Exception\FileException;
	use Symfony\Component\HttpFoundation\File\UploadedFile;
	use Symfony\Component\String\Slugger\AsciiSlugger;
	
	class Utility
	{
		private $mediaProfil;
		private $producteurRepository;
		
		public function __construct($profilDirectory, ProducteurRepository $producteurRepository)
		{
			$this->mediaProfil = $profilDirectory;
			$this->producteurRepository = $producteurRepository;
		}
		
		/**
		 * @param UploadedFile $file
		 * @param $media
		 * @return string
		 */
		public function upload(UploadedFile $file, $media=null): string
		{
			$slugger = new AsciiSlugger();
			$originalFileName = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
			$safeFilename = $slugger->slug($originalFileName);
			$newFilename = $safeFilename.'-'.Time().'.'.$file->guessExtension();
			
			// Deplacement du fichier dans le repertoire dédié
			try {
				$file->move($this->mediaProfil, $newFilename);
			} catch (FileException $exception){
				return $exception;
			}
			
			return $newFilename;
		}
		
		/**
		 * @param $ancienMedia
		 * @param $media
		 * @return bool
		 */
		public function removeUpload($ancienMedia, $media=null): bool
		{
			if ($media === 'profil') unlink($this->mediaProfil.'/'.$ancienMedia);
			else return false;
			
			return true;
		}
		
		/**
		 * @return string
		 */
		public function matricule(): string
		{
			$producteur = $this->producteurRepository->findOneBy([],['id'=>'DESC']);
			if ($producteur){
				$id = $producteur->getId();
			}else{
				$id = 1;
			}
			
			if ($id < 10) $num = '00'.$id;
			elseif ($id < 100) $num = '0'.$id;
			else $num = $id;
			
			return $matricule = date('ym').''.$num.''.$this->lettre_aleatoire();
		}
		
		public function lettre_aleatoire()
		{
			$alphabet="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			
			return $alphabet[rand(0,25)];
		}
	}
